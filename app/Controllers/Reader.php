<?php
namespace Controllers;

use \ViewItems\PageViews\ReaderStripView;
use \ViewItems\PageViews\ReaderPageView;

class Reader {
	/**
	 * Runs page process.
	 */
	public function begin () {
		$db = \Core\Database::getInstance ();
		
		// Fetch manga directory
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = $db->query ($q);
		
		$manga_dir = $r[0]['config_value'];
		
		$manga_info = [];
		
		// Fetch manga info by ID
		$q = '
			SELECT
				`s`.`folder_name` AS `series_folder`,
				`v`.`folder_name` AS `volume_folder`,
				`v`.`sort` AS `volume_sort`,
				`c`.`folder_name` AS `chapter_folder`,
				`c`.`sort` AS `chapter_sort`,
				`c`.`is_archive`
			FROM `manga_directories_series` AS `s`
			JOIN `manga_directories_volumes` AS `v`
				ON `s`.`manga_id` = `v`.`manga_id`
			JOIN `manga_directories_chapters` AS `c`
				ON `v`.`volume_id` = `c`.`volume_id`
			WHERE `s`.`manga_id` = '.$_GET['s'].'
				AND `v`.`sort` = '.$_GET['v'].'
				AND `c`.`sort` IN ('.$_GET['c'].','.($_GET['c'] + 1).')';
		$r = $db->query ($q);
		
		if ($r === false)
			return ['file_paths' => []];
		
		$next_chapter = count($r) ? $_GET['c'] + 1 : null;
		
		// Get the first row (which should be the sort we want to display)
		$r = current ($r);
		
		$path = "{$manga_dir}\\{$r['series_folder']}\\{$r['volume_folder']}\\{$r['chapter_folder']}";
			
		$file_paths = [];
		if ($r['is_archive'] === '1') {
			$files = array_keys (\Core\ZipManager::readFiles ($path));
			
			foreach ($files as $file) {
				if (substr ($file, -1) === '/') {
					continue;
				}
				
				$file_paths[] = "{$path}#{$file}";
			}
		} else {
			// Reading list of images from a directory
			$files = array_values ($this->dirToArray($path));
			
			foreach ($files as $file) {
				$file_paths[] = "{$path}\\{$file}";
			}
		}
		
		$view_parameters = [];
		$view_parameters['file_paths'] = $file_paths;
		
		if ($next_chapter !== null) {
			$view_parameters['next_chapter_link'] = "\\reader?s={$_GET['s']}&v={$_GET['v']}&c={$next_chapter}";
		} else {
			$view_parameters['next_chapter_link'] = null;
		}
		
		// Get the reader view style
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "reader_display_style"';
		$r = $db->query ($q);
		
		$reader_display_style = (int) $r[0]['config_value'];
		
		if ($reader_display_style === 2) {
			// Display as a strip
			return (new \Services\View\Controller ())->
				buildViewService ($_SERVER['DOCUMENT_ROOT'])->
				buildView (
					[
						'name' => 'ReaderStrip',
						'CSS' => ['ReaderStrip'],
						'HTML' => 'ReaderStrip',
						'JS' => ['LazyLoader', 'LazyLoaderEvents', 'ReaderStrip']
					],
					$view_parameters
				);
		} else if ($reader_display_style === 1) {
			// Display as a single page with left and right arrows
			return (new \Services\View\Controller ())->
				buildViewService ($_SERVER['DOCUMENT_ROOT'])->
				buildView (
					[
						'name' => 'ReaderPage',
						'CSS' => ['ReaderPage'],
						'HTML' => 'ReaderPage',
						'JS' => ['LazyLoader', 'LazyLoaderEvents', 'ReaderPage']
					],
					$view_parameters
				);
		}
	}
	
	/**
	 * Create an array reflecting the directory structure at a given location.
	 * 
	 * @param string $dir file path to folder
	 * 
	 * @return array directory structure
	 */
	private function dirToArray ($dir) {
		$result = array();
		
		$cdir = scandir($dir);
		foreach ($cdir as $key => $value) {
			if (!in_array ($value, array ('.', '..'))) {
				if (is_dir ($dir . DIRECTORY_SEPARATOR . $value)) {
					$result[$value] = $this->dirToArray ($dir . DIRECTORY_SEPARATOR . $value);
				} else {
					$result[] = $value;
				}
			}
		}
		
		return ($result);
	}
}

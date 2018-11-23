<?php
declare (strict_types = 1);

namespace Controllers;

use \ViewItems\PageViews\ReaderStripView;
use \ViewItems\PageViews\ReaderPageView;

class Reader {
	/**
	 * Runs page process.
	 */
	public function begin () {
		$db = \Core\Database::getInstance ();
		
		if (empty ($_GET['sid']) || empty ($_GET['cid'])) {
			throw new \Exception ('Missing required query variables.');
		}
		
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
				`mc`.`chapter_id`,
				`mc`.`global_sort`,
				`ds`.`folder_name` AS `series_folder`,
				`dc`.`folder_name` AS `chapter_folder`,
				`dc`.`is_archive`
			FROM `metadata_chapters` AS `mc`
			JOIN `directories_chapters` AS `dc`
				ON `mc`.`chapter_id` = `dc`.`chapter_id`
			JOIN `connections_series` AS `cs`
				ON `dc`.`chapter_id` = `cs`.`chapter_id`
			JOIN `directories_series` AS `ds`
				ON `cs`.`series_id` = `ds`.`series_id`
			WHERE `cs`.`series_id` = '.$_GET['sid'].'
				AND `mc`.`global_sort` IN (
					(
						SELECT `global_sort`
						FROM `metadata_chapters`
						WHERE `chapter_id` = '.$_GET['cid'].'
					),
					(
						SELECT `global_sort`
						FROM `metadata_chapters`
						WHERE `chapter_id` = '.$_GET['cid'].'
					) + 1
				)';
		$r = $db->query ($q);
		
		if ($r === false)
			return ['file_paths' => []];
		
		$next_chapter = count($r) > 1 ? end ($r)['chapter_id'] : null;
		
		// Get the first row (which should be the sort we want to display)
		$r = current ($r);
		
		$path = "{$manga_dir}\\{$r['series_folder']}\\{$r['chapter_folder']}";
			
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
			$view_parameters['next_chapter_link'] = "\\reader?sid={$_GET['sid']}&cid={$next_chapter}";
		} else {
			$view_parameters['next_chapter_link'] = '';
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

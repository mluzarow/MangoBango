<?php
namespace Controllers;

use \ViewItems\PageViews\ReaderStripView;
use \ViewItems\PageViews\ReaderPageView;

class Reader {
	public function __construct () {
		// Fetch manga directory
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$manga_directory = $r[0]['config_value'];
		
		$manga_info = [];
		
		// Fetch manga info by ID
		$q = '
			SELECT `path`
			FROM `manga_directories_series`
			WHERE `manga_id` = '.$_GET['s'];
		$r = \Core\Database::query ($q);
		
		$manga_info['series_folder'] = $r[0]['path'];
		
		$q = '
			SELECT `filename`, `sort`
			FROM `manga_directories_volumes`
			WHERE `manga_id` = '.$_GET['s'].'
				AND `sort` = '.$_GET['v'];
		$r = \Core\Database::query ($q);
		
		$manga_info['volume_folder'] = $r[0]['filename'];
		$manga_info['volume_sort'] = $r[0]['sort'];
		
		$q = '
			SELECT `filename`, `sort`, `is_archive`
			FROM `manga_directories_chapters`
			WHERE `manga_id` = '.$_GET['s'].'
				AND `volume_sort` = '.$_GET['v'].'
				AND `sort` IN ('.$_GET['c'].','.($_GET['c'] + 1).')';
		$r = \Core\Database::query ($q);
		
		$next_chapter = null;
		if (count ($r) > 1) {
			$next_chapter = $_GET['c'] + 1;
		}
		
		// Get the first row (which should be the sort we want to display)
		$row = current ($r);
		
		$manga_info['chapter'] = $r[0]['filename'];
		$manga_info['chapter_sort'] = $r[0]['sort'];
		$manga_info['is_archive'] = $r[0]['is_archive'];
		
		$path = "{$manga_directory}\\{$manga_info['series_folder']}\\{$manga_info['volume_folder']}\\{$manga_info['chapter']}";
			
		$file_paths = [];
		if ($manga_info['is_archive'] === '1') {
			$files = array_keys (\Core\ZipManager::readFiles ($path));
			
			foreach ($files as $file) {
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
		$r = \Core\Database::query ($q);
		
		$reader_display_style = (int) $r[0]['config_value'];
		
		if ($reader_display_style === 2) {
			// Display as a strip
			$view = new ReaderStripView ($view_parameters);
		} else if ($reader_display_style === 1) {
			// Display as a single page with left and right arrows
			$view = new ReaderPageView ($view_parameters);
		}
		
		$view->render ();
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

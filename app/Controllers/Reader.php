<?php
namespace Controllers;

use \ViewItems\PageViews\ReaderStripView;

class Reader {
	public function __construct () {
		// Fetch manga directory
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$manga_directory = $r[0]['config_value'];
		
		// Fetch manga info by ID
		$q = '
			SELECT DISTINCT
				`s`.`path` AS `series_folder`,
				`v`.`filename` AS `volume_folder`,
				`v`.`sort` AS `volume_sort`,
				`c`.`filename` AS `chapter`,
				`c`.`sort` AS `chapter_sort`,
				`c`.`is_archive`
			FROM `manga_directories_series` AS `s`
			JOIN `manga_directories_volumes` AS `v`
				ON `s`.`manga_id` = `v`.`manga_id`
			JOIN `manga_directories_chapters` AS `c`
				ON `v`.`sort` = `c`.`volume_sort`
			WHERE `s`.`manga_id` = '.$_GET['s'].'
				AND `v`.`sort` = '.$_GET['v'].'
				AND `c`.`sort` IN('.$_GET['c'].','.($_GET['c'] + 1).')';
		$r = \Core\Database::query ($q);
		
		$next_chapter = null;
		if (count ($r) > 1) {
			$next_chapter = $_GET['c'] + 1;
		}
		
		// Get the first row (which should be the sort we want to display)
		$row = current ($r);
		
		$path = "{$manga_directory}\\{$row['series_folder']}\\{$row['volume_folder']}\\{$row['chapter']}";
			
		$image_list = [];
		if ($row['is_archive'] === '1') {
			$zip_dict = \Core\ZipManager::readFiles ($path);
			
			foreach ($zip_dict as $filename => $blob) {
				$ext = explode ('.', $filename);
				$ext = end ($ext);
				
				if ($ext !== 'jpg' && $ext !== 'png') {
					continue;
				}
				
				$image_list[] = '<img src="data:image/'.$ext.';base64,'.$blob.'" />';
			}
		} else {
			// Reading list of images from a directory
			$chapter_dir_tree = $this->dirToArray($path);
			
			foreach ($chapter_dir_tree as $page) {
				$file_path = "{$path}\\{$page}";
			
				$f = fopen ($file_path, 'r');
				$blob = fread ($f, filesize ($file_path));
				fclose ($f);
			
				$ext = explode ('.', $page);
				$ext = end ($ext);
				
				$image_list[] = '<img src="data:image/'.$ext.';base64,'.base64_encode ($blob).'" />';
			}
		}
		
		$view_parameters = [];
		$view_parameters['image_list'] = $image_list;
		
		if ($next_chapter !== null) {
			$view_parameters['next_chapter_html'] =
			'<a href="\reader?s='.$_GET['s'].'&v='.$_GET['v'].'&c='.$next_chapter.'">
				Continue to next chaper.
			</a>';
		} else {
			$view_parameters['next_chapter_html'] = null;
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
			echo $view->render ();
		} else if ($reader_display_style === 1) {
			// Display as a single page with left and right arrows
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

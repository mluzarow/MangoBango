<?php
namespace Controllers;

use ViewItems\PageViews\ImportView;

/**
 * Page controller managing manga importing and guiding user through the process
 * of cataloging files and metadata tagging.
 */
class Import {
	/**
	 * Constructor for page controller Import.
	 */
	public function __construct () {
		if (!empty($_POST)) {
			return;
		}
		
		$manga = $this->ajaxScanLibrary();
		// \Core\Debug::prettyPrint ($manga);
		$this->saveNewManga ($manga);
	}
	
	/**
	 * AJAX method which scans the manga library for any new series.
	 * 
	 * @return array dictionary of new series and all its files in order
	 */
	public function ajaxScanLibrary () {
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$directory_tree = $this->dirToArray ($r[0]['config_value']);
		
		$new_content = [];
		foreach ($directory_tree as $series_name => $series_contents) {
			// Check if this folder is already bound to a series
			$q = '
				SELECT `manga_id` FROM `manga_directories_series`
				WHERE `path` = "'.\Core\Database::sanitize ($series_name).'"';
			$r = \Core\Database::query ($q);
			
			if (!empty ($r)) {
				continue;
			}
			
			$new_manga = [
				'name' => $series_name,
				'name_original' => null,
				'path' => $series_name,
				'volumes' => []
			];
			
			foreach ($series_contents as $volume_name => $volume_contents) {
				if (is_string ($volume_contents)) {
					// Is a file
					continue;
				}
				
				// Try and get the volume number
				preg_match ('/((?:[0-9]+)(?:\.(?:[0-9]+))?)/', $volume_name, $matches);
				$vol_number = $matches[0];
				
				$new_manga['volumes'][$vol_number] = [
					'filename' => $volume_name,
					'chapters' => []
				];
				
				foreach ($volume_contents as $chapter_name => $chapter_contents) {
					$is_archive = 0;
					
					if (is_string ($chapter_contents)) {
						// Is a file
						$file_segs = explode ('.', $chapter_contents);
						$ext = end ($file_segs);
						
						$chap_filename = $chapter_contents;
						
						if ($ext === 'zip') {
							// Is archive
							$is_archive = 1;
						} else {
							// Is an image
							continue;
						}
					} else {
						$chap_filename = $chapter_name;
					}
					
					// Try and get the chapter number
					preg_match ('/((?:[0-9]+)(?:\.(?:[0-9]+))?)/', $chap_filename, $matches);
					$chap_number = $matches[0];
					
					$new_manga['volumes'][$vol_number]['chapters'][$chap_number] = [
						'filename' => $chap_filename,
						'is_archive' => $is_archive
					];
				}
				
				ksort ($new_manga['volumes'][$vol_number]['chapters']);
			}
			
			ksort ($new_manga['volumes']);
			
			$new_content[] = $new_manga;
		}
		
		return ($new_content);
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
	
	/**
	 * Saves new manga into the database.
	 * 
	 * @param array $manga_list dictionary of new manga
	 */
	private function saveNewManga ($manga_list) {
		// Get the new manga ID
		$q = '
			SELECT MAX(`manga_id`) AS `max_id` FROM `manga_metadata`';
		$r = \Core\Database::query ($q);
		
		if ($r !== false) {
			if ($r[0]['max_id'] === null) {
				$max_id = 1;
			} else {
				$max_id = $r[0]['max_id'] + 1;
			}
		}
		
		foreach ($manga_list as $manga) {
			$q = '
				INSERT INTO `manga_metadata`
					(`manga_id`, `name`, `name_original`)
				VALUES
					('.$max_id.', "'.$manga['name'].'", "'.$manga['name_original'].'")';
			$r = \Core\Database::query ($q);
			
			$q = '
				INSERT INTO `manga_directories_series`
					(`manga_id`, `path`)
				VALUES
					('.$max_id.', "'.$manga['path'].'")';
			$r = \Core\Database::query ($q);
			
			$vol_sort = 1;
			foreach ($manga['volumes'] as $volume) {
				$q = '
					INSERT INTO `manga_directories_volumes`
						(`sort`, `manga_id`, `filename`)
					VALUES
						('.$vol_sort.', '.$max_id.', "'.$volume['filename'].'")';
				$r = \Core\Database::query ($q);
				
				$chap_sort = 1;
				foreach ($volume['chapters'] as $chapter) {
					$q = '
						INSERT INTO `manga_directories_chapters`
							(
								`sort`,
								`manga_id`,
								`volume_sort`,
								`filename`,
								`is_archive`
							)
						VALUES
							(
								'.$chap_sort.',
								'.$max_id.',
								'.$vol_sort.',
								"'.$chapter['filename'].'",
								'.$chapter['is_archive'].'
							)';
					$r = \Core\Database::query ($q);
					
					$chap_sort++;
				}
				
				$vol_sort++;
			}
			
			$max_id++;
		}
	}
}

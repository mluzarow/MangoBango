<?php
namespace Controllers;

use ViewItems\PageViews\ConfigView;

/**
 * Controller for processing configs to display on the configs page.
 */
class Config {
	/**
	 * Constructor for page controller Config.
	 */
	public function __construct () {
		$this->db = \Core\Database::getInstance ();
		
		if (!empty ($_POST)) {
			// If there is post data (this controller called via ajax), ignore
			// standard page setup instructions
			return;
		}
		
		$q = '
			SELECT `config_name`, `config_value`
			FROM `server_configs`';
		$r = $this->db->query ($q);
		
		$configs_dict = [];
		foreach ($r as $row) {
			$configs_dict[$row['config_name']] = $row['config_value'];
		}
		
		$view_parameters = [];
		$view_parameters['reader_display_style'] = $configs_dict['reader_display_style'];
		$view_parameters['manga_directory'] = $configs_dict['manga_directory'];
		$view_parameters['library_view_type'] = $configs_dict['library_view_type'];
		
		$view = new ConfigView ($view_parameters);
		$view->render ();
	}
	
	/**
	 * AJAX method for updating the manga library.
	 */
	public function ajaxRescanLibrary () {
		$manga = $this->scanLibrary ();
		$this->saveNewManga ($manga);
		
		return (true);
	}
	
	/**
	 * AJAX method for saving updated configs to the DB.
	 */
	public function ajaxUpdateConfigs () {
		$configs = json_decode ($_POST['config'], true);
		
		if (!empty ($configs['reader_display_style'])) {
			$q = '
				UPDATE `server_configs` 
				SET `config_value` = '.$configs['reader_display_style'].' 
				WHERE `config_name` = "reader_display_style"';
			$r = $this->db->query ($q);
		}
		
		if (!empty ($configs['manga_directory'])) {
			$q = '
				UPDATE `server_configs` 
				SET `config_value` = "'.$this->db->sanitize ($configs['manga_directory']).'" 
				WHERE `config_name` = "manga_directory"';
			$r = $this->db->query ($q);
		}
		
		if (!empty ($configs['manga_directory'])) {
			$q = '
				UPDATE `server_configs` 
				SET `config_value` = '.$configs['library_view_type'].' 
				WHERE `config_name` = "library_view_type"';
			$r = $this->db->query ($q);
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
	
	/**
	 * Scans the manga library for any new series.
	 * 
	 * @return array dictionary of new series and all its files in order
	 */
	private function scanLibrary () {
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = $this->db->query ($q);
		
		$directory_tree = $this->dirToArray ($r[0]['config_value']);
		
		$new_content = [];
		foreach ($directory_tree as $series_name => $series_contents) {
			// Check if this folder is already bound to a series
			$q = '
				SELECT `manga_id` FROM `manga_directories_series`
				WHERE `path` = "'.$this->db->sanitize ($series_name).'"';
			$r = $this->db->query ($q);
			
			if (!empty ($r)) {
				continue;
			}
			
			$new_manga = [
				'name' => $series_name,
				'name_original' => null,
				'path' => $series_name,
				'series_cover' => null,
				'volumes' => []
			];
			
			foreach ($series_contents as $volume_name => $volume_contents) {
				if (is_string ($volume_contents)) {
					// Is a file
					if (strpos ($volume_contents, 'series_cover') !== false) {
						$file_segs = explode ('.', $volume_contents);
						$new_manga['series_cover'] = end ($file_segs);
					}
					
					continue;
				}
				
				// Try and get the volume number
				preg_match ('/((?:[0-9]+)(?:\.(?:[0-9]+))?)/', $volume_name, $matches);
				$vol_number = $matches[0];
				
				$new_manga['volumes'][$vol_number] = [
					'filename' => $volume_name,
					'cover' => null,
					'spine' => null,
					'index' => null,
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
							if (strpos ($chapter_contents, 'cover') !== false) {
								// Is a cover image
								$new_manga['volumes'][$vol_number]['cover'] = $ext;
							} else if (strpos ($chapter_contents, 'spine') !== false) {
								// Is a spine image
								$new_manga['volumes'][$vol_number]['spine'] = $ext;
							} else if (strpos ($chapter_contents, 'index') !== false) {
								// Is an index image
								$new_manga['volumes'][$vol_number]['index'] = $ext;
							}
							
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
	 * Saves new manga into the database.
	 * 
	 * @param array $manga_list dictionary of new manga
	 */
	private function saveNewManga ($manga_list) {
		// Get the new manga ID
		$q = '
			SELECT MAX(`manga_id`) AS `max_id` FROM `manga_metadata`';
		$r = $this->db->query ($q);
		
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
			$r = $this->db->query ($q);
			
			$q = '
				INSERT INTO `manga_directories_series`
					(`manga_id`, `path`, `series_cover`)
				VALUES
					('.$max_id.', "'.$manga['path'].'", "'.$manga['series_cover'].'")';
			$r = $this->db->query ($q);
			
			$vol_sort = 1;
			foreach ($manga['volumes'] as $volume) {
				$q = '
					INSERT INTO `manga_directories_volumes`
						(`sort`, `manga_id`, `filename`, `cover`, `spine`, `index`)
					VALUES
						(
							'.$vol_sort.',
							'.$max_id.',
							"'.$volume['filename'].'",
							"'.$volume['cover'].'",
							"'.$volume['spine'].'",
							"'.$volume['index'].'"
						)';
				$r = $this->db->query ($q);
				
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
					$r = $this->db->query ($q);
					
					$chap_sort++;
				}
				
				$vol_sort++;
			}
			
			$max_id++;
		}
	}
}

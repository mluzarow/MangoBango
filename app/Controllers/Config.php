<?php
declare (strict_types = 1);

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
		
		if (!empty ($configs['assets_directory'])) {
			$q =
				'UPDATE server_configs
				SET config_value = :v
				WHERE config_name = "assets_directory"';
			$r = $this->db->execute ($q, ['v' => $configs['assets_directory']]);
		}
		
		if (!empty ($configs['directory_structure'])) {
			$q =
				'UPDATE server_configs
				SET config_value = :v
				WHERE config_name = "directory_structure"';
			$r = $this->db->execute ($q, ['v' => $configs['directory_structure']]);
		}
		
		if (!empty ($configs['reader_display_style'])) {
			$q =
				'UPDATE server_configs
				SET config_value = :v
				WHERE config_name = "reader_display_style"';
			$r = $this->db->execute ($q, ['v' => $configs['reader_display_style']]);
		}
		
		if (!empty ($configs['manga_directory'])) {
			$q =
				'UPDATE server_configs
				SET config_value = :v
				WHERE config_name = "manga_directory"';
			$r = $this->db->execute ($q, ['v' => $configs['manga_directory']]);
		}
		
		if (!empty ($configs['library_view_type'])) {
			$q =
				'UPDATE server_configs
				SET config_value = :v
				WHERE config_name = "library_view_type"';
			$r = $this->db->execute ($q, ['v' => $configs['library_view_type']]);
		}
	}
	
	/**
	 * Runs page process.
	 */
	public function begin () {
		$q =
			'SELECT config_name, config_value
			FROM server_configs';
		$r = $this->db->query ($q);
		
		$configs_dict = [];
		foreach ($r as $row) {
			$configs_dict[$row['config_name']] = $row['config_value'];
		}
		
		$view_parameters = [];
		$view_parameters['assets_directory'] = $configs_dict['assets_directory'];
		$view_parameters['reader_display_style'] = (int) $configs_dict['reader_display_style'];
		$view_parameters['manga_directory'] = $configs_dict['manga_directory'];
		$view_parameters['library_view_type'] = (int) $configs_dict['library_view_type'];
		$view_parameters['directory_structure'] = $configs_dict['directory_structure'];
		
		return (new \Services\View\Controller ())->
			buildViewService ($_SERVER['DOCUMENT_ROOT'])->
			buildView (
				[
					'name' => 'Config',
					'CSS' => ['Config'],
					'HTML' => 'Config',
					'JS' => ['Config']
				],
				$view_parameters
			);
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
		$q =
			'SELECT config_name, config_value
			FROM server_configs
			WHERE config_name IN ("directory_structure", "manga_directory")';
		$r = $this->db->query ($q);
		
		$configs = [];
		foreach ($r as $row) {
			$configs[$row['config_name']] = $row['config_value'];
		}
		
		$directory_tree = $this->dirToArray ($configs['manga_directory']);
		
		$new_content = [];
		foreach ($directory_tree as $series_name => $series_contents) {
			// Check if this folder is already bound to a series
			$q =
				'SELECT series_id FROM directories_series
				WHERE folder_name = :v';
			$r = $this->db->execute ($q, ['v' => $series_name]);
			
			if (!empty ($r)) {
				continue;
			}
			
			// Try and load the metadata file
			$metadata = $configs['manga_directory'].DIRECTORY_SEPARATOR.$series_name.DIRECTORY_SEPARATOR.'info.json';
			$f = fopen ($metadata, 'r');
			
			if (!empty($f)) {
				$blob = fread ($f, filesize ($metadata));
				fclose ($f);
			} else {
				$blob = '[]';
			}
			
			$new_manga = [
				'folder_name' => $series_name,
				'metadata' => json_decode ($blob, true),
				'chapters' => []
			];
				
			foreach ($series_contents as $chapter_name => $chapter_contents) {
				$is_archive = 0;
				
				if (is_string ($chapter_contents)) {
					// Is a file
					$file_segs = explode ('.', $chapter_contents);
					$ext = end ($file_segs);
					
					$chap_folder_name = $chapter_contents;
					
					if ($ext === 'zip') {
						// Is archive
						$is_archive = 1;
					} else {
						continue;
					}
				} else {
					$chap_folder_name = $chapter_name;
				}
					
				// Try and get the chapter number
				preg_match ('/((?:[0-9]+)(?:\.(?:[0-9]+))?)/', $chap_folder_name, $matches);
				$chap_number = $matches[0];
				
				$new_manga['chapters'][$chap_number] = [
					'folder_name' => $chap_folder_name,
					'is_archive' => $is_archive
				];
			}
			
			ksort ($new_manga['chapters']);
			
			$new_content[] = $new_manga;
		}
		
		return $new_content;
	}
	
	/**
	 * Saves new manga into the database.
	 * 
	 * @param array $manga_list dictionary of new manga
	 */
	private function saveNewManga ($manga_list) {
		foreach ($manga_list as $manga) {
			$q =
				'INSERT INTO metadata_series
					(name, name_original, summary, genres)
				VALUES
					(:name, :name_original, :summary, :genres)';
			$r = $this->db->execute (
				$q,
				[
					'name' => empty($manga['metadata']['manga_info']['title']) ?
						'' : $manga['metadata']['manga_info']['title'],
					'name_original' => empty($manga['metadata']['manga_info']['original_title']) ?
						'' : $manga['metadata']['manga_info']['original_title'],
					'summary' => empty($manga['metadata']['manga_info']['description']) ?
						'' : $manga['metadata']['manga_info']['description'],
					'genres' => empty($manga['metadata']['manga_info']['tags']) ?
						'[]' : json_encode ($manga['metadata']['manga_info']['tags'])
				]
			);
			
			$new_id_series = $this->db->getLastIndex ();
			
			$q =
				"INSERT INTO directories_series
					(series_id, folder_name)
				VALUES
					({$new_id_series}, \"{$manga['folder_name']}\")";
			$r = $this->db->query ($q);
			
			$q =
				"INSERT INTO images_series
					(series_id, cover_ext)
				VALUES
					({$new_id_series}, \"\")";
			$r = $this->db->query ($q);
			
			$chap_sort = 1;
			foreach ($manga['chapters'] as $chapter) {
				$q =
					"INSERT INTO metadata_chapters
						(global_sort, chapter_name)
					VALUES
						({$chap_sort}, \"\")";
				$r = $this->db->query ($q);
				
				$new_id_chapter = $this->db->getLastIndex ();
				
				$q =
					"INSERT INTO directories_chapters
						(chapter_id, folder_name, is_archive)
					VALUES
						(
							{$new_id_chapter},
							\"{$chapter['folder_name']}\",
							{$chapter['is_archive']}
						)";
				$r = $this->db->query ($q);
				
				$q =
					"INSERT INTO connections_series
						(chapter_id, series_id)
					VALUES
						({$new_id_chapter}, {$new_id_series})";
				$r = $this->db->query ($q);
				
				$chap_sort++;
			}
		}
	}
}

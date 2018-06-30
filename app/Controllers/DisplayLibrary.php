<?php
namespace Controllers;

use ViewItems\PageViews\DisplayLibraryView;
use ViewItems\PageViews\DisplayLibraryBookcaseView;

class DisplayLibrary {
	public function __construct () {
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$manga_directory = $r[0]['config_value'];
		$directory_tree = $this->dirToArray ($manga_directory);
		
		// Check for library view type
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "library_view_type"';
		$r = \Core\Database::query ($q);
		
		$library_view_type = (int) $r[0]['config_value'];
		
		if ($library_view_type === 1) {
			// Display as series of covers
			$series_data = $this->getImagesCovers ($directory_tree);
			$view_parameters = $this->processImagesCovers ($series_data, $manga_directory);
			$view = new DisplayLibraryView ($view_parameters);
		} else if ($library_view_type === 2) {
			// Display as bookcase
			$series_data = $this->getImagesSpines ($directory_tree);
			$view_parameters = $this->processImagesSpines ($series_data, $manga_directory);
			$view = new DisplayLibraryBookcaseView ($view_parameters);
		}
		
		echo $view->render ();
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
	 * Collects series cover image locations.
	 * 
	 * @param array $directory_tree manga directory tree
	 * 
	 * @return array dictionary of series covers
	 */
	private function getImagesCovers ($directory_tree) {
		$series_data = [];
		
		foreach ($directory_tree as $series_folder => $series) {
			foreach ($series as $name => $contents) {
				if (is_string ($contents) && strpos ($contents, 'series_cover') !== false) {
					$series_data[$series_folder] = $contents;
				}
			}
		}
		
		return ($series_data);
	}
	
	/**
	 * Collects volume spine image locations.
	 * 
	 * @param array $directory_tree manga directory tree
	 * 
	 * @return array dictionary of series spines by volume
	 */
	private function getImagesSpines ($directory_tree) {
		$series_data = [];
		
		foreach ($directory_tree as $series_folder => $series) {
			$series_data[$series_folder] = [];
			
			foreach ($series as $volume_folder => $volume) {
				if (is_string($volume)) {
					continue;
				}
				
				foreach ($volume as $chapter_folder => $contents) {
					if (is_string ($contents) && strpos ($contents, 'spine') !== false) {
						$series_data[$series_folder][$volume_folder] = $contents;
					}
				}
			}
		}
		
		return ($series_data);
	}
	
	/**
	 * Process series cover images into view-ready strings.
	 * 
	 * @param array  $series_data     dictionary of series covers
	 * @param string $manga_directory manga directory
	 * 
	 * @return array view parameters dictionary
	 */
	private function processImagesCovers ($series_data, $manga_directory) {
		$view_parameters = [];
		$view_parameters['series'] = [];
		
		foreach ($series_data as $name => $image) {
			$file_path = "{$manga_directory}\\{$name}\\{$image}";
			
			$f = fopen ($file_path, 'r');
			$blob = fread ($f, filesize ($file_path));
			fclose ($f);
			
			$ext = explode ('.', $image)[1];
			
			$view_parameters['series'][] = [
				'title' => $name,
				'link' => "/displaySeries?series={$name}",
				'source' => "data:image/{$ext};base64,".base64_encode ($blob)
			];
		}
		
		return ($view_parameters);
	}
	
	/**
	 * Process volume spine images into view-ready strings.
	 * 
	 * @param array  $series_data     dictionary of series spines by volume
	 * @param string $manga_directory manga directory
	 * 
	 * @return array view parameters dictionary
	 */
	private function processImagesSpines ($series_data, $manga_directory) {
		$view_parameters = [];
		$view_parameters['spines'] = [];
		$view_parameters['series_links'] = [];
		
		foreach ($series_data as $series => $volumes) {
			$view_parameters['spines'][$series] = [];
			$view_parameters['series_links'][$series] = "/displaySeries?series={$series}";
			
			foreach ($volumes as $volume => $spine) {
				$file_path = "{$manga_directory}\\{$series}\\{$volume}\\{$spine}";
				
				$f = fopen ($file_path, 'r');
				$blob = fread ($f, filesize ($file_path));
				fclose ($f);
				
				$ext = explode ('.', $spine)[1];
				
				$view_parameters['spines'][$series][] = "data:image/{$ext};base64,".base64_encode ($blob);
			}
		}
		
		return ($view_parameters);
	}
}

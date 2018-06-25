<?php
namespace Controllers;

use ViewItems\PageViews\DisplayLibraryView;

class DisplayLibrary {
	public function __construct () {
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$test_directory = $r[0]['config_value'];
		$directory_tree = $this->dirToArray ($test_directory);
		
		// Check for library view type
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "library_view_type"';
		$r = \Core\Database::query ($q);
		
		$library_view_type = $r[0]['library_view_type'];
		
		$series_data = [];
		foreach ($directory_tree as $series_folder => $series) {
			foreach ($series as $name => $contents) {
				if (is_string ($contents) && strpos ($contents, 'series_cover') !== false) {
					$series_data[$series_folder] = $contents;
				}
			}
		}
		
		$view_parameters = [];
		$view_parameters['series'] = [];
		foreach ($series_data as $name => $image) {
			$file_path = "{$test_directory}\\{$name}\\{$image}";
			
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
		
		$view = new DisplayLibraryView ($view_parameters);
		
		echo $view->render ();
	}
	
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

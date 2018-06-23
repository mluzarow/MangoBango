<?php
namespace Controllers;

use ViewItems\PageViews\DisplayLibraryView;

class DisplayLibrary {
	public function __construct () {
		$test_directory = 'C:\Users\Mark\Desktop\MangoBango_manga_directory';
		$directory_tree = $this->dirToArray ($test_directory);
		
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

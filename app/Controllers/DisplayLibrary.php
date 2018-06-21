<?php
namespace Controllers;

use ViewItems\PageViews\DisplayLibraryView;

class DisplayLibrary {
	public function __construct () {
		$test_directory = 'C:\Users\Mark\Desktop\MangoBango_manga_directory';
		$directory_tree = $this->dirToArray ($test_directory);
		
		$view_parameters = [];
		$view_parameters['volumes'] = [];
		
		foreach ($directory_tree as $series_folder => $series) {
			foreach ($series as $volume_folder => $volume) {
				if (in_array ('cover.png', $volume)) {
					$ext = 'png';
					$ext_uri = 'png';
				} else if (in_array ('cover.jpg', $volume)) {
					$ext = 'jpg';
					$ext_uri = 'jpeg';
				}
				
				$file_path = "{$test_directory}\\{$series_folder}\\{$volume_folder}\\cover.{$ext}";
				
				$f = fopen ($file_path, 'r');
				$blob = fread ($f, filesize ($file_path));
				fclose ($f);
				
				$view_parameters['volumes'][] = [
					'link' => "/reader?source={$test_directory}\\{$series_folder}\\{$volume_folder}\\",
					'source' => "data:image/{$ext_uri};base64,".base64_encode ($blob)
				];
			}
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

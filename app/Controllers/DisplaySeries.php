<?php
namespace Controllers;

use ViewItems\PageViews\DisplaySeriesView;

/**
 * Controller managing data for view class DispaySeriesView.
 */
class DisplaySeries {
	/**
	 * Constructor for controller DisplaySeries.
	 */
	public function __construct () {
		$test_directory = 'C:\Users\Mark\Desktop\MangoBango_manga_directory\\'.$_GET['series'];
		$directory_tree = $this->dirToArray ($test_directory);
		
		$view_parameters = [];
		$view_parameters['volumes'] = [];
		foreach ($directory_tree as $volume_folder => $volume_contents) {
			// Skip llose files like images in the series folder
			if (!is_array($volume_contents)) {
				continue;
			}
			
			foreach ($volume_contents as $chapter) {
				// Skip folders
				if (is_array ($chapter)) {
					continue;
				}
				
				if (!empty (preg_match ('/^cover\.(?:png|jpg)$/', $chapter))) {
					$file_path = "{$test_directory}\\{$volume_folder}\\{$chapter}";
					
					$f = fopen ($file_path, 'r');
					$blob = fread ($f, filesize ($file_path));
					fclose ($f);
					
					$ext = explode ('.', $chapter)[1];
					
					$view_parameters['volumes'][] = [
						'link' => "/reader?series=\"{$_GET['series']}\"&volume=\"{$volume_folder}\"",
						'source' => "data:image/{$ext};base64,".base64_encode ($blob)
					];
				}
			}
		}
		
		$view = new DisplaySeriesView ($view_parameters);
		
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
}

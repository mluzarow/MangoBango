<?php
namespace Controllers;

use \ViewItems\PageViews\ReaderStripView;

class Reader {
	public function __construct () {
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$test_directory = $r[0]['config_value'].'\\'.$_GET['series'].'\\'.$_GET['volume'];
		$directory_tree = $this->dirToArray ($test_directory);
		
		$next_chapter = ((int) ltrim ($_GET['chapter'], 'c')) + 1;
		$next_chapter_folder = sprintf ('c%04d', $next_chapter);
		
		$next_chapter_exits = false;
		$image_list = [];
		
		// Get the ready type
		if (array_key_exists ($_GET['chapter'], $directory_tree)) {
			// Reading list of images from a directory
			$test_directory .= '\\'.$_GET['chapter'];
			$chapter_dir_tree = $directory_tree[$_GET['chapter']];
			
			foreach ($chapter_dir_tree as $page) {
				$file_path = $test_directory.'\\'.$page;
			
				$f = fopen ($file_path, 'r');
				$blob = fread ($f, filesize ($file_path));
				fclose ($f);
			
				$ext = explode ('.', $page)[1];
			
				$image_list[] = '<img src="data:image/'.$ext.';base64,'.base64_encode ($blob).'" />';
			}
			
			if (array_key_exists ($next_chapter_folder, $directory_tree)) {
				$next_chapter_exits = true;
			}
		} else if (in_array ($_GET['chapter'].'.zip', $directory_tree)) {
			// Reading a zip file
			$test_directory .= '\\'.$_GET['chapter'].'.zip';
			$zip_dict = \Core\ZipManager::readFiles ($test_directory);
			
			foreach ($zip_dict as $filename => $blob) {
				$ext = explode ('.', $filename)[1];
				
				$image_list[] = '<img src="data:image/'.$ext.';base64,'.$blob.'" />';
			}
			
			if (in_array ($next_chapter_folder.'.zip', $directory_tree)) {
				$next_chapter_exits = true;
			}
		}
		
		$view_parameters = [];
		$view_parameters['image_list'] = $image_list;
		
		if ($next_chapter_exits !== false) {
			$view_parameters['next_chapter_html'] =
			'<a href="\reader?series='.$_GET['series'].'&volume='.$_GET['volume'].'&chapter='.$next_chapter_folder.'">
				Continue to chapter '.$next_chapter.'
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

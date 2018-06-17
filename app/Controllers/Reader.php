<?php
namespace Controllers;

class Reader {
	public function __construct () {
		$directory_tree = $this->dirToArray ($_GET['source']);
		
		$output =
		'<style>
			body {
				margin: 0;
				background-color: #474747;
			}
		
			.strip_wrap {
				margin: 0 auto;
				width: 1200px;
				max-width: 100%;
				background-color: #fff;
				box-shadow: 0 0 25px 20px rgba(0, 0, 0, 0.3);
			}
			
			.strip_wrap img {
				margin: 0 auto;
				max-width: 100%;
				display: block;
			}
		</style>
		<div class="strip_wrap">';
		
		foreach ($directory_tree as $chapter_folder => $chapter) {
			if (!is_array($chapter)) {
				// Conver and other meta content
				continue;
			}
			
			foreach ($chapter as $page) {
				$file_path = $_GET['source'].'\\'.$chapter_folder.'\\'.$page;
				
				$f = fopen ($file_path, 'r');
				$blob = fread ($f, filesize ($file_path));
				fclose ($f);
				
				$output .= '<img src="data:image/jpeg;base64,'.base64_encode ($blob).'" />';
			}
		}
		
		$output .= '</div>';
		
		echo $output;
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

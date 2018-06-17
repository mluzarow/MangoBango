<?php
namespace Controllers;

class DisplayLibrary {
	public function __construct () {
		$test_directory = 'C:\Users\Mark\Desktop\MangoBango_manga_directory';
		$directory_tree = $this->dirToArray ($test_directory);
		
		$output = 
		'<style>
			.manga_cover_wrap {
				margin: 10px;
				width: 300px;
				display: inline-block;
			}
			
			.manga_cover_wrap a {
				display: block;
			}
			
			.manga_cover_wrap a img {
				width: 100%;
			}
		</style>';
		
		foreach ($directory_tree as $series_folder => $series) {
			foreach ($series as $volume_folder => $volume) {
				if (in_array ('cover.png', $volume)) {
					$file_path = $test_directory.'\\'.$series_folder.'\\'.$volume_folder.'\\cover.png';
					
					$f = fopen ($file_path, 'r');
					$blob = fread ($f, filesize ($file_path));
					fclose ($f);
					
					$output .=
					'<div class="manga_cover_wrap">
						<a href="http://69.47.79.25:6969/reader?source='.$test_directory.'\\'.$series_folder.'\\'.$volume_folder.'\\">
							<img src="data:image/jpeg;base64,'.base64_encode ($blob).'"/>
						</a>
					</div>';
				} else if (in_array ('cover.jpg', $volume)) {
					$file_path = $test_directory.'\\'.$series_folder.'\\'.$volume_folder.'\\cover.jpg';
					
					$f = fopen ($file_path, 'r');
					$blob = fread ($f, filesize ($file_path));
					fclose ($f);
					
					$output .=
					'<div class="manga_cover_wrap">
						<a href="http://69.47.79.25:6969/reader?source='.$test_directory.'\\'.$series_folder.'\\'.$volume_folder.'\\">
							<img src="data:image/jpeg;base64,'.base64_encode ($blob).'"/>
						</a>
					</div>';
				}
			}
		}
		
		
		
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

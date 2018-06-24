<?php
namespace Controllers;

class Reader {
	public function __construct () {
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$test_directory = $r[0]['config_value'].'\\'.$_GET['series'].'\\'.$_GET['volume'];
		$directory_tree = $this->dirToArray ($test_directory);
		
		// Get the reader view style
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "reader_display_style"';
		$r = \Core\Database::query ($q);
		
		$reader_display_style = (int) $r[0]['config_value'];
		
		if ($reader_display_style === 2) {
			// Display as a strip
		} else if ($reader_display_style === 1) {
			// Display as a single page with left and right arrows
		}
		
		$output =
		'<style>
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
				$file_path = $test_directory.'\\'.$chapter_folder.'\\'.$page;
				
				$f = fopen ($file_path, 'r');
				$blob = fread ($f, filesize ($file_path));
				fclose ($f);
				
				$ext = explode ('.', $page)[1];
				
				$output .= '<img src="data:image/'.$ext.';base64,'.base64_encode ($blob).'" />';
			}
			echo $output;
			$output = '';
		}
		
		$output = '</div>';
		
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

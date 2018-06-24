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
		
		$next_chapter = ((int) ltrim ($_GET['chapter'], 'c')) + 1;
		$next_chapter_folder = sprintf ('c%04d', $next_chapter);
		
		if (!array_key_exists ($next_chapter_folder, $directory_tree)) {
			$next_chapter = false;
		}
		
		$test_directory .= '\\'.$_GET['chapter'];
		$directory_tree = $directory_tree[$_GET['chapter']];
		
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
			
			.strip_wrap .continue_btn {
				display: block;
				background-color: #d68100;
			}
			
			.strip_wrap .continue_btn:hover {
				background-color: #ffbb54;
			}
			
			.strip_wrap .continue_btn a {
				padding: 20px;
				display: block;
				color: #000;
				text-align: center;
				text-decoration: none;
				font-family: Arial;
				font-size: 2em;
			}
		</style>
		<div class="strip_wrap">';
		
		foreach ($directory_tree as $page) {
			$file_path = $test_directory.'\\'.$page;
			
			$f = fopen ($file_path, 'r');
			$blob = fread ($f, filesize ($file_path));
			fclose ($f);
			
			$ext = explode ('.', $page)[1];
			
			$output .= '<img src="data:image/'.$ext.';base64,'.base64_encode ($blob).'" />';
		}
		
		if ($next_chapter !== false) {
			$output .=
			'<div class="continue_btn">
				<a href="\reader?series='.$_GET['series'].'&volume='.$_GET['volume'].'&chapter='.$next_chapter_folder.'">
					Continue to chapter '.$next_chapter.'
				</a>
			</div>';
		}
		
		$output .= '
		</div>';
		
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

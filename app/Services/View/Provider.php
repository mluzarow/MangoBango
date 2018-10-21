<?php
namespace Services\View;

/**
 * View file provider.
 */
class Provider {
	/**
	 * Fetches file contents.
	 * 
	 * @param string $filename name of HTML file to open.
	 * 
	 * @return string file contents or empty if open failed
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	public function fetchFile (string $filename) : string {
		return (string) file_get_contents (
			"{$_SERVER['DOCUMENT_ROOT']}\\ViewItems\\HTML\\{$filename}.php"
		);
	}
	
	/**
	 * Validates that the requested files exist.
	 * 
	 * @param array $config dictionary of view file names to load
	 * 
	 * @throws InvalidArgumentException on unloadable file
	 * @throws TypeError on non-array parameter
	 */
	public function validateFiles (array $config) {
		$root = $_SERVER['DOCUMENT_ROOT'];
		
		foreach ($config as $name => $file_list) {
			if ($name === 'name' || empty ($file_list))
				continue;
			
			switch ($name) {
				case 'CSS':
					$ext = 'css';
					break;
				case 'HTML':
					$ext = 'php';
					break;
				case 'JS':
					$ext = 'js';
					break;
			}
			
			if ($name === 'HTML') {
				$filepath = "{$root}\\ViewItems\\{$name}\\{$file_list}.{$ext}";
				
				if (!file_exists ($filepath))
					throw new \InvalidArgumentException (
						"File at {$filepath} could not be loaded."
					);
				
				continue;
			}
			
			foreach ($file_list as $file) {
				$filepath = "{$root}\\ViewItems\\{$name}\\{$file}.{$ext}";
				
				if (!file_exists ($filepath))
					throw new \InvalidArgumentException (
						"File at {$filepath} could not be loaded."
					);
			}
		}
	}
}

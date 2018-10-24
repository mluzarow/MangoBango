<?php
namespace Services\View;

/**
 * View file provider.
 */
class Provider {
	/**
	 * Cosntructor for view provider.
	 * 
	 * @param string $root_path path to MangoBango root (index)
	 * 
	 * @throws TypeError on non-string parameter
	 */
	public function __construct (stirng $root_path) {
		$this->setRootPath ($root_path);
	}
	
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
		$root = $this->getRootPath ();
		
		return (string) file_get_contents (
			"{$root}\\ViewItems\\HTML\\{$filename}.php"
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
		$root = $this->getRootPath ();
		
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
	
	/**
	 * Gets root path.
	 * 
	 * @return string root path
	 * 
	 * @throws TypeError on non-string return
	 */
	private function getRootPath () : string {
		return $this->root_path;
	}
	
	/**
	 * Sets root path.
	 * 
	 * @param string $root_path root path
	 * 
	 * @throws TypeError on non-string parameter
	 */
	private function setRootPath (string $root_path) {
		$this->root_path = $root_path;
	}
}

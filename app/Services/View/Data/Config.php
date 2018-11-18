<?php
declare (strict_types = 1);

namespace Services\View\Data;

/**
 * View data object for the Config view.
 */
class Config implements IViewData {
	/**
	 * @var string $directory_structure  structure of files in directory
	 * @var int    $library_view_type    library view type
	 * @var string $manga_directory      manga directory setting
	 * @var int    $reader_display_style reader display style setting
	 */
	private $directory_structure;
	private $library_view_type;
	private $manga_directory;
	private $reader_display_style;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param string $directory_structure  structure of files in directory
	 * @param int    $library_view_type    library view type
	 * @param string $manga_directory      manga directory setting
	 * @param int    $reader_display_style reader display style setting
	 * 
	 * @throws TypeError on invalid parameter type
	 */
	public function __construct (
		string $directory_structure,
		int $library_view_type,
		string $manga_directory,
		int $reader_display_style
	) {
		$this->setDirectoryStructure ($directory_structure);
		$this->setLibraryViewType ($library_view_type);
		$this->setMangaDirectory ($manga_directory);
		$this->setReaderDisplayStyle ($reader_display_style);
	}
	
	/**
	 * Gets the manga file directory structure setting.
	 * 
	 * @return string structure of files in directory
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getDirectoryStructure () : string {
		return $this->directory_structure;
	}
	
	/**
	 * Gets the library view type.
	 * 
	 * @return int library view type
	 * 
	 * @throws TypeError on non-int return
	 */
	public function getLibraryViewType () : int {
		return $this->library_view_type;
	}
	
	/**
	 * Gets the manga directory setting.
	 * 
	 * @return string manga directory setting
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getMangaDirectory () : string {
		return $this->manga_directory;
	}
	
	/**
	 * Gets the reader display style setting.
	 * 
	 * @return int reader display style setting
	 * 
	 * @throws TypeError on non-int return
	 */
	public function getReaderDisplayStyle () : int {
		return $this->reader_display_style;
	}
	
	/**
	 * Gets the view name to which the data is tied (the controller's name).
	 * 
	 * @return string page controller name
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getViewName () : string {
		return 'Config';
	}
	
	/**
	 * Sets the manga directory structure setting.
	 * 
	 * @param string $directory_structure structure of files in directory
	 * 
	 * @throws TypeError on non-string config value
	 */
	private function setDirectoryStructure (string $directory_structure) {
		$this->directory_structure = $directory_structure;
	}
	
	/**
	 * Sets the library view type.
	 * 
	 * @param int $config library view type
	 * 
	 * @throws TypeError on non-int config value
	 * @throws InvalidArgumentException on config value out of bounds
	 */
	private function setLibraryViewType (int $config) {
		if (!in_array($config, [1, 2])) {
			throw new \InvalidArgumentException (
				'Argument (Library View Type) value must in set [1, 2]; '.
				"{$config} given."
			);
		}
		
		$this->library_view_type = $config;
	}
	
	/**
	 * Sets the manga directory setting.
	 * 
	 * @param string $config manga directory setting
	 * 
	 * @throws TypeError on non-string config value
	 */
	private function setMangaDirectory (string $config) {
		$this->manga_directory = trim ($config);
	}
	
	/**
	 * Sets the reader display style setting.
	 * 
	 * @param int $config reader display style setting
	 * 
	 * @throws TypeError on non-int config value
	 * @throws InvalidArgumentException on config value out of bounds
	 */
	private function setReaderDisplayStyle (int $config) {
		if (!in_array($config, [1, 2])) {
			throw new \InvalidArgumentException (
				'Argument (Reader Display Style) value must in set [1, 2]; '.
				"{$config} given.");
		}
		
		$this->reader_display_style = $config;
	}
}

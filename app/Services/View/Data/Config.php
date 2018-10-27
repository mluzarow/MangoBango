<?php
namespace Services\View\Data;

/**
 * View data object for the Config view.
 */
class Config implements IViewData {
	/**
	 * @var int library view type
	 */
	private $library_view_type;
	/**
	 * @var string manga directory setting
	 */
	private $manga_directory;
	/**
	 * @var int reader display style setting
	 */
	private $reader_display_style;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param int    $library_view_type    library view type
	 * @param string $manga_directory      manga directory setting
	 * @param int    $reader_display_style reader display style setting
	 * 
	 * @throws TypeError on invalid parameter type
	 */
	public function __construct (
		int $library_view_type,
		string $manga_directory,
		int $reader_display_style
	) {
		$this->setLibraryViewType ($library_view_type);
		$this->setMangaDirectory ($manga_directory);
		$this->setReaderDisplayStyle ($reader_display_style);
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

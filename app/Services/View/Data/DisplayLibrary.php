<?php
namespace Services\View\Data;

/**
 * View data object for the DisplayLibrary view.
 */
class DisplayLibrary implements IViewData  {
	/**
	 * @var array dictionary of manga data
	 */
	private $manga_data;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param array $manga_data dictionary of manga data
	 * 
	 * @throws TypeError on non-array parameter
	 */
	public function __construct (array $manga_data) {
		$this->setMangaData ($manga_data);
	}
	
	/**
	 * Gets the view name to which the data is tied (the controller's name).
	 * 
	 * @return string page controller name
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getViewName () : string {
		return 'DisplayLibrary';
	}
}

<?php
declare (strict_types = 1);

namespace Services\View\Data;

/**
 * Generic view data object for any view.
 */
class ViewData implements IViewData {
	/**
	 * Constructor for view data object.
	 * 
	 * @param array $view_data dictionary of view data
	 */
	public function __construct (array $view_data) {
		$this->view_data = $view_data;
	}
	
	/**
	 * Gets view data item by key.
	 * 
	 * @param string $key view data key
	 * 
	 * @return mixed requested view data or null if not found
	 */
	public function getViewData (string $key) {
		return isset($this->view_data[$key]) ? $this->view_data[$key] : null;
	}
	
	/**
	 * Required method.
	 */
	public function getViewName () : string
	{
		return '';
	}
}

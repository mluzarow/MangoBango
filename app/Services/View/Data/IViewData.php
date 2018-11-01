<?php
declare (strict_types = 1);

namespace Services\View\Data;

/**
 * View data interface.
 */
interface IViewData {
	/**
	 * Gets the view name to which the data is tied (the controller's name).
	 * 
	 * @return string page controller name
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getViewName () : string;
}

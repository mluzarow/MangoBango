<?php
namespace Services\View\Data;

/**
 * View data object for the DisplaySeries view.
 */
class DisplaySeries implements IViewData {
	/**
	 * Gets the view name to which the data is tied (the controller's name).
	 * 
	 * @return string page controller name
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getViewName () : string {
		return 'DisplaySeries';
	}
}

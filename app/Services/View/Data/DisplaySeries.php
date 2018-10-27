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
	
	/**
	 * Gets chapter anchor data list.
	 * 
	 * @return array chapter data list
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getChapters () : array {
		return $this->chapters;
	}
	
	/**
	 * Gets list of series genres.
	 * 
	 * @return array list of series genres
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getGenres () : array {
		return $this->genres;
	}
	
	/**
	 * Gets series summary.
	 * 
	 * @return string series summary
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getSummary () : string {
		if (empty ($this->summary)) {
			return '<i>No summary available.</i>';
		} else {
			return $this->summary;
		}
	}
	
	/**
	 * Gets manga title.
	 * 
	 * @return string manga title
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getTitle () : string {
		if (empty ($this->title)) {
			return '<i>No Title</i>';
		} else {
			return $this->title;
		}
	}
	
	/**
	 * Gets display data for each volume.
	 * 
	 * @return array display data for each volume
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getVolumes () : array {
		return $this->volumes;
	}
}

<?php
namespace ViewItems\PageViews;

use ViewItems\ViewAbstract;

/**
 * View class displaying the library in the form of a bookcase with each volume
 * rendered as a spine.
 */
class DisplayLibraryBookcaseView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		return ('');
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		return ('');
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
	}
	
	protected function setSpines (array $spines) {
		$this->spines = $spines;
	}
	
	protected function setSeriesLinks (array $series_links) {
		$this->series_links = $series_links;
	}
	
	protected function getSpines () {
		return ($this->spines);
	}
	
	protected function getSeriesLinks () {
		return ($this->series_links);
	}
}

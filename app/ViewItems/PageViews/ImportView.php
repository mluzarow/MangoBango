<?php
namespace ViewItems\PageViews;

use ViewItems\ViewAbstract;

/**
 * View for importer output the importing squence.
 */
class ImportView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		return ('<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/Importer.css">');
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
}

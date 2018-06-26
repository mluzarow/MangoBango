<?php
namespace Controllers;

use ViewItems\PageViews\ImportView;

/**
 * Page controller managing manga importing and guiding user through the process
 * of cataloging files and metadata tagging.
 */
class Import {
	/**
	 * Constructor for page controller Import.
	 */
	public function __construct () {
		if (!empty($_POST)) {
			return;
		}
		
		$view = new ImportView ([]);
		echo $view->render ();
	}
}

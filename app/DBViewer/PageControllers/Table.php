<?php
namespace DBViewer\PageControllers;

use DBViewer\Views\TableView;

/**
 * Page controller for displaying table content.
 */
class Table {
	/**
	 * Constructor for page controller Table.
	 */
	public function __construct () {
		$view_parameters = [];
		$view_parameters['table_name'] = $_GET['table_name'];
		
		$q = '
			SELECT *
			FROM `'.$_GET['table_name'].'`';
		$r = \Core\Database::query ($q);
		
		$view_parameters['table_rows'] = $r;
		
		$view = new TableView ($view_parameters);
		$view->render ();
	}
}

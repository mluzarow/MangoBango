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
		$q = "SELECT * FROM `{$_GET['table_name']}`";
		$r = \Core\Database::query ($q);
		
		new TableView ($r);
	}
}

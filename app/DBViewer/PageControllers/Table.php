<?php
namespace DBViewer\PageControllers;

use DBViewer\Views\TableView;

class Table {
	public function __construct () {
		$q = "SELECT * FROM `{$_GET['table_name']}`";
		$r = \Core\Database::query ($q);
		
		new TableView ($r);
	}
}


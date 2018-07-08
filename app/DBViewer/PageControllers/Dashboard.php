<?php
namespace DBViewer\PageControllers;

use DBViewer\Views\DashboardView;

class Dashboard {
	public function __construct () {
		$view_parameters = [];
		$view_parameters['details'] = \Core\Database::getConnectionData ();
		
		$r = \Core\Database::query ('show tables');
		
		foreach ($r as $result) {
			$view_parameters['tables'][] = $result['Tables_in_server'];
		}
		
		$view = new DashboardView ($view_parameters);
		$view->render ();
	}
}

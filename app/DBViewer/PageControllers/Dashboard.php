<?php
namespace DBViewer\PageControllers;

use DBViewer\Views\DashboardView;

class Dashboard {
	public function __construct () {
		new DashboardView ();
	}
}

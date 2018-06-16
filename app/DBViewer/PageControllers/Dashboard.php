<?php
namespace DBViewer\PageControllers;

class Dashboard {
	public function __construct () {
		echo "DASHBOARD!!!";
		$r = \Core\Database::query ('SELECT * FROM `server_configs`');
		print_r($r);
	}
}

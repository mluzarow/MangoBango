<?php
namespace Controllers;

class ConfigDisplay {
	public function ajaxProcessConfigs () {
		echo 'php running.';
		return (json_encode (['success!!!']));
	}
}
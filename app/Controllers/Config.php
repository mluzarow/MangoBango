<?php
namespace Controllers;

use ViewItems\PageViews\ConfigView;

/**
 * Controller for processing configs to display on the configs page.
 */
class Config {
	/**
	 * Constructor for page controller Config.
	 */
	public function __construct () {
		$q = '
			SELECT `config_name`, `config_value`
			FROM `server_configs`';
		$r = \Core\Database::query ($q);
		
		$configs_dict = [];
		foreach ($r as $row) {
			$configs_dict[$row['config_name']] = $row['config_value'];
		}
		
		$view_parameters = [];
		$view_parameters['reader_display_style'] = $configs_dict['reader_display_style'];
		
		$view = new ConfigView ($view_parameters);
		echo $view->render ();
	}
}

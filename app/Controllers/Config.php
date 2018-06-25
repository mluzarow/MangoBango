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
		if (!empty ($_POST)) {
			// If there is post data (this controller called via ajax), ignore
			// standard page setup instructions
			return;
		}
		
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
		$view_parameters['manga_directory'] = $configs_dict['manga_directory'];
		$view_parameters['library_view_type'] = $configs_dict['library_view_type'];
		
		$view = new ConfigView ($view_parameters);
		echo $view->render ();
	}
	
	/**
	 * AJAX method for saving updated configs to the DB.
	 */
	public function ajaxUpdateConfigs () {
		$configs = json_decode ($_POST['configs'], true);
		
		$q = '
			UPDATE `server_configs` 
			SET `config_value` = '.$configs['reader_display_style'].' 
			WHERE `config_name` = "reader_display_style"';
		$r = \Core\Database::query ($q);
		
		$q = '
			UPDATE `server_configs` 
			SET `config_value` = "'.\Core\Database::sanitize ($configs['manga_directory']).'" 
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$q = '
			UPDATE `server_configs` 
			SET `config_value` = '.$configs['library_view_type'].' 
			WHERE `config_name` = "library_view_type"';
		$r = \Core\Database::query ($q);
	}
}

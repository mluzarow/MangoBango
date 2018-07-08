<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewAbstract;

/**
 * Page view for the first time server setup script.
 */
class FirstTimeSetupView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/FirstTimeSetup.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="setup_wrap">
			<div class="header">Library Settings</div>
			<div class="setup_inner_wrap">
				<div class="setup_message">
					This setup utility will guide you through the process of
					performing a first time setup of the manga server.
					<br>
					<br>
					Any configurations set here can be edited freely in the future
					from the "configs" page, accessable through the top navigation
					bar.
				</div>
				<div class="setup_start_btn">Run Setup</div>
			</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		$output =
		'';
		
		return ($output);
	}
}

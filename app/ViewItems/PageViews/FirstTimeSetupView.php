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
			<div class="header">First Time Setup</div>
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
				<div class="setup_btn setup_start_btn">Run Setup</div>
				<div class="divider section_two"></div>
				<div class="setup_message section_two">
					Create a user below to use as the admin user. You can later 
					change your username, password, or permissions on the config
					page.
				</div>
				<div class="setup_btn add_user section_two">Add User</div>
				<div class="divider section_three"></div>
				<div class="setup_message section_three">
					Congradulations! You are all set up! Redirecting you to the
					login page in 10 seconds...
				</div>
			</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		$output =
		'<script type="text/javascript" src="/External/Javascript/jquery-3.3.1.js"></script>
		<script type="text/javascript" src="/ViewItems/JS/FirstTimeSetup.js"></script>';
		
		return ($output);
	}
}

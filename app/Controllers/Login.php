<?php
namespace Controllers;

use \ViewItems\PageViews\LoginView;

/**
 * Page controller for the login page.
 */
class Login {
	/**
	 * Constructor for page controller Login.
	 */
	public function __construct () {
		$view = new LoginView ([]);
		$view->render ();
	}
}

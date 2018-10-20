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
		if ((new \Core\SessionManager ())->isLoggedIn () === true) {
			// Redirect to home page
			header ('Location: /', true, 301);
			exit;
		}
		
		\Core\MetaPage::setTitle ('Login');
		\Core\MetaPage::setHead ('');
		\Core\MetaPage::setBody ('');
		
		$view = new LoginView ([]);
		$view->render ();
	}
}

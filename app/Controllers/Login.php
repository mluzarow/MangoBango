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
		if ((\Core\SessionManager::getInstance())->isLoggedIn () === true) {
			// Route user to home page
			\Core\MetaPage::setHead ('
				<script>
					window.location = "/";
				</script>
			');
			\Core\MetaPage::setBody ('');
			return;
		}

		\Core\MetaPage::setTitle ('Login');
		\Core\MetaPage::setHead ('');
		\Core\MetaPage::setBody ('');

		$view = new LoginView ([]);
		$view->render ();
	}
}

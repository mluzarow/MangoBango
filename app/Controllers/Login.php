<?php
declare (strict_types = 1);

namespace Controllers;

use \ViewItems\PageViews\LoginView;

/**
 * Page controller for the login page.
 */
class Login {
	/**
	 * Runs page process.
	 */
	public function begin () {
		if ((new \Core\SessionManager ())->isLoggedIn () === true) {
			// Redirect to home page
			header ('Location: /', true, 301);
			exit;
		}
		
		return (new \Services\View\Controller ())->
			buildViewService ($_SERVER['DOCUMENT_ROOT'])->
			buildView (
				[
					'name' => '',
					'CSS' => ['Login'],
					'HTML' => 'Login',
					'JS' => ['Login']
				],
				[]
			);
	}
}

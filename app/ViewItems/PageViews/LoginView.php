<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewAbstract;

/**
 * Page view rendering output for the server login page.
 */
class LoginView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/Login.css">'
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="login_wrap">
			<div class="login_box">
				<form class="login_form">
					<div class="title_strip">
						<span>MangoBango</span>
					</div>
					<input id="username_field" type="text" autocomplete="off" />
					<input id="password_field" type="text" autocomplete="off" />
				</form>
				<input id="login_btn" type="button" value="Log In" />
			</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
	}
}

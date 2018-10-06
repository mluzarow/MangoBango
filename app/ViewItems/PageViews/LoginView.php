<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewTemplate;

/**
 * Page view rendering output for the server login page.
 */
class LoginView extends ViewTemplate {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/Login.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="login_wrap">
			<div class="login_box">
				<div class="title_strip">
					<span>MangoBango</span>
				</div>
				<div class="login_box_inner">
					<div class="warning">
						The username / password combination was incorrect.
					</div>
					<form class="login_form">
						<div class="input_wrap">
							<input id="username_field" type="text" autocomplete="off" placeholder="Username" />
						</div>
						<div class="input_wrap">
							<input id="password_field" type="password" autocomplete="off" placeholder="Password" />
						</div>
					</form>
					<input id="login_btn" type="button" value="Log In" />
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
		<script type="text/javascript" src="/ViewItems/JS/Login.js"></script>';
		
		return ($output);
	}
}

<?php
namespace Core;

/**
 * Controller managing user session data and logins.
 */
class SessionManager {
	/**
	 * AJAX method validates the given username / password given via the login
	 * form.
	 * 
	 * @return bool login success status
	 */
	public function ajaxValidateLogin () {
		if (
			empty ($_POST['username']) ||
			empty ($_POST['password'])
		) {
			// Missing POST data
			return (false);
		}
		
		// Get saved value
		$q = '
			SELECT `username`, `password` FROM `users`
			WHERE `username` = "'.$_POST['username'].'"';
		$r = \Core\Database::query ($q);
		
		if (empty ($r)) {
			// No matching username found
			return (false);
		}
		
		$saved_pass = $r[0]['password'];
		$user_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
		if ($user_pass === $saved_pass) {
			return (true);
		} else {
			return (false);
		}
	}
}

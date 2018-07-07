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
	 * @return int login success status
	 */
	public function ajaxValidateLogin () {
		if (
			empty ($_POST['username']) ||
			empty ($_POST['password'])
		) {
			// Missing POST data
			return (0);
		}
		
		// Get saved value
		$q = '
			SELECT `username`, `password` FROM `users`
			WHERE `username` = "'.\Core\Database::sanitize ($_POST['username']).'"';
		$r = \Core\Database::query ($q);
		
		if (empty ($r)) {
			// No matching username found
			return (0);
		}
		
		$pass_valid = password_verify($_POST['password'], $r[0]['password']);
		
		if ($pass_valid === true) {
			return (1);
		} else {
			return (0);
		}
	}
}

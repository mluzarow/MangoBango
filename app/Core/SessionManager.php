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
			$this->setSessionItem ('username', $_POST['username']);
			
			return (1);
		} else {
			return (0);
		}
	}
	
	/**
	 * Gets all session data for the current user's session.
	 * 
	 * @return array user session data
	 */
	public function getSessionData () {
		return ($_SESSION);
	}
	
	/**
	 * Gets session value for the given key.
	 * 
	 * @param  string $key session dictionary key
	 * 
	 * @return string session dictionary value for given key
	 *
	 * @throws TypeError on non-string parameter & non-string return
	 */
	public function getSessionItem (string $key) : string {
		if (array_key_exists ($key, $_SESSION)) {
			$value = $_SESSION[$key];
		} else {
			$value = '';
		}
		
		return ($value);
	}
	
	/**
	 * Checks if user is logged in.
	 * 
	 * @return bool user logged in flag
	 */
	public function isLoggedIn () {
		if (!empty ($_SESSION['username'])) {
			return (true);
		} else {
			return (false);
		}
	}
	
	/**
	 * Loads a user's session.
	 */
	public function loadSession () {
		session_start ();
	}
	
	/**
	 * Updates user session data with give key value pair.
	 * 
	 * @param string $key   session dictionary key
	 * @param string $value session dictionary value for given key
	 * 
	 * @throws TypeError on non-string parameters
	 */
	public function setSessionItem (string $key, string $value) {
		$_SESSION[$key] = $value;
	}
	
	/**
	 * Unload a user's session.
	 */
	public function unloadSession () {
		session_unset ();
		session_destroy ();
	}
}

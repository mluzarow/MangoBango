<?php
declare (strict_types = 1);

namespace Core;

/**
 * Controller managing user session data and logins.
 */
class SessionManager {
	/**
	 * AJAX method for creating a new user.
	 * 
	 * @return int creation success code
	 * 
	 * @throws TypeError on non-int return code
	 */
	public function ajaxCreateUser () : int {
		if (
			empty ($_POST['username']) ||
			empty ($_POST['password'])
		) {
			// Missing POST data
			return (0);
		}
		
		$status = $this->createUser ($_POST['username'], $_POST['password'], 'admin');
		
		if ($status === true) {
			return (1);
		} else {
			// Failed to create user
			return (0);
		}
	}
	
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
		
		$db = \Core\Database::getInstance ();
		
		// Get saved value
		$q = '
			SELECT `username`, `password` FROM `users`
			WHERE `username` = "'.$db->sanitize ($_POST['username']).'"';
		$r = $db->query ($q);
		
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
	 * Creates a new user and updated the database with said user.
	 * 
	 * @param string $username new user's username
	 * @param string $password new user's plaintext password
	 * @param string $type     new user's user type
	 * 
	 * @return bool creation success flag
	 * 
	 * @throws TypeError on:
	 *         - Non-string username
	 *         - Non-string password
	 *         - Non-string user type
	 *         - Non-bool return success flag
	 */
	public function createUser (string $username, string $password, string $type) : bool {
		$db = \Core\Database::getInstance ();
		
		$pass_hash = password_hash ($password, PASSWORD_DEFAULT);
		
		$q = '
			INSERT INTO `users`
				(`username`, `password`, `type`)
			VALUES
				("'.$username.'", "'.$pass_hash.'", "'.$type.'")';
		$r = $db->query ($q);
		
		if ($r === false) {
			return (false);
		} else {
			return (true);
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

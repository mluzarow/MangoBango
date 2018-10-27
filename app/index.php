<?php
use \Core\AJAXProcessor;

// Autoload classes based on a 1:1 mapping from namespace to directory structure.
spl_autoload_register(function ($className) {
	$ds = DIRECTORY_SEPARATOR;
	$dir = __DIR__;
	
	// Replace namespace separator with directory separator
	$className = str_replace('\\', $ds, $className);
	
	// Get full name of file containing the required class
	$file = "{$dir}{$ds}{$className}.php";
	
	// Get file if it is readable
	if (is_readable ($file)) {
		require_once $file;
	}
});

$db_status = true;
try {
	$db = \Core\Database::getInstance ();
} catch (\Throwable $e) {
	$db_status = false;
}

// Load user session
$user_session = new \Core\SessionManager ();
$user_session->loadSession ();

// Parse the URL here
$url_split = explode ('?', $_SERVER['REQUEST_URI']);

$current_segs = $url_split[0];
$current_segs = trim ($current_segs, '/');
$current_segs = explode ('/', $current_segs);

if (count ($current_segs) === 1) {
	if (empty ($current_segs[0])) {
		unset ($current_segs[0]);
		$current_segs = array_values ($current_segs);
	}
}

if ($db_status === false) {
	// DB is not set up; ignore everything and route to the first time setup page
	$uri = strtolower (implode ('/', $current_segs));
	
	if (
		$uri === 'firsttimesetup' ||
		$uri === 'ajax/controllers/firsttimesetup/ajaxrunsetup'
	) {
		if ($current_segs[0] === 'ajax') {
			unset ($current_segs[0]);
			$current_segs = array_values ($current_segs);
			
			$ajax = new AJAXProcessor ($current_segs);
			$result = $ajax->fireTargetMethod ();
			
			echo $result;
			return;
		} else {
			new \Controllers\FirstTimeSetup ();
		}
	} else {
		// Redirect to first time setup
		header ('Location: /firsttimesetup', true, 301);
		exit;
	}
	
	echo \Core\MetaPage::render ();
	return;
} else if (in_array ('firsttimesetup', $current_segs)) {
	// Database is set up, so do not allow access to this script again. Redirect
	// to login page.
	header ('Location: /login', true, 301);
	exit;
}

if ((new \Core\SessionManager ())->isLoggedIn () === false) {
	// Not logged in; should only be able to ajax request
	// SessionManager::ajaxValidateLogin and Controllers/Login
	$uri = strtolower (implode ('/', $current_segs));
	
	if (
		$uri === 'ajax/core/sessionmanager/ajaxvalidatelogin' ||
		$uri === 'login'
	) {
		if ($current_segs[0] === 'ajax') {
			unset ($current_segs[0]);
			$current_segs = array_values ($current_segs);
			
			$ajax = new AJAXProcessor ($current_segs);
			$result = $ajax->fireTargetMethod ();
			
			echo $result;
			return;
		} else {
			new \Controllers\Login ();
		}
	} else {
		// Redirect to login page
		header ('Location: /login', true, 301);
		exit;
	}
	
	echo \Core\MetaPage::render ();
	return;
}

if (!empty($current_segs)) {
	if ($current_segs[0] === 'ajax') {
		// If the first segment is ajax, pass the rest of the data to the ajax
		// controller so it can decide what methods to run.
		unset ($current_segs[0]);
		$current_segs = array_values ($current_segs);
		
		$ajax = new AJAXProcessor ($current_segs);
		$result = $ajax->fireTargetMethod ();
		
		echo $result;
		return;
	} else {
		$namespace = '\Controllers';
		
		for ($i = 0; $i < count ($current_segs); $i++) {
			$namespace .= '\\'.$current_segs[$i];
		}
		
		$user_login = $user_session->getSessionItem ('username');
		(new \ViewItems\PageViews\MetaView (['username' => $user_login]))->render ();
		
		try {
			new $namespace ();
		} catch (Error $e) {
			echo $e->getMessage ();
		}
	}
} else {
	// Empty so its just the home page.
	$user_login = $user_session->getSessionItem ('username');
	(new \ViewItems\PageViews\MetaView (['username' => $user_login]))->render ();
	new \Controllers\Home ();
}

echo \Core\MetaPage::render ();

<?php
declare (strict_types = 1);
define ('APP_PATH', __DIR__);
define ('VENDOR_PATH', str_replace(DIRECTORY_SEPARATOR.'app', '', __DIR__).DIRECTORY_SEPARATOR.'vendor');

require VENDOR_PATH.DIRECTORY_SEPARATOR.'autoload.php';

use \Core\AJAXProcessor;
use Services\View\Data\ViewItem;

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

// Handle loose exceptions
$whoops = new \Whoops\Run;
$whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

/**
 * Gets the master view object.
 * 
 * @param string   $username username
 * @param ViewItem $view     child view object
 * 
 * @return ViewItem master view object
 * 
 * @throws TypeError on invalid parameter or return type
 */
function getMasterView (string $username, ViewItem $view) : ViewItem {
	return (new \Services\View\Controller ())->
		buildViewService ($_SERVER['DOCUMENT_ROOT'])->
		buildView (
			[
				'name' => 'Master',
				'CSS' => ['UIFrame'],
				'HTML' => 'Master',
				'JS' => ['dropdown', 'logout']
			],
			[
				'username' => $username,
				'view_content' => $view
			]
		);
}

/**
 * Gets page view HTML.
 * 
 * @param string   $title page title
 * @param ViewItem $view  child view object
 * 
 * @return string view HTML
 * 
 * @throws TypeError on invalid parameters or return type
 */
function getPageView (string $title, ViewItem $view) : string {
	return (new \Services\View\Controller ())->
		buildViewService ($_SERVER['DOCUMENT_ROOT'])->
		buildPage (
			$title,
			$view
		);
}

$db = \Core\Database::getInstance ();

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
		} else {
			echo getPageView (
				'Login',
				(new \Controllers\Login ())->begin ()
			);
		}
	} else {
		// Redirect to login page
		header ('Location: /login', true, 301);
		exit;
	}
	
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
		
		try {
			echo getPageView (
				preg_replace ('/(?<!^)(?<! )[A-Z]/',' $0', end ($current_segs)),
				getMasterView (
					$user_session->getSessionItem ('username'),
					(new $namespace ())->begin ()
				)
			);
		} catch (Error $e) {
			echo $e->getMessage ();
		}
	}
} else {
	// Empty so its just the home page.
	echo getPageView (
		'Home Page',
		getMasterView (
			$user_session->getSessionItem ('username'),
			(new \Controllers\Home ())->begin ()
		)
	);
}

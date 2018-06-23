<?php
// use Controllers\Displaylibrary;
// use DBViewer\Controller\DBViewerMain;
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

\Core\Database::initialize ();

echo
'<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="/External/Javascript/jquery-3.3.1.js"></script>
		<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/UIFrame.css">
	</head>
	<body>
		<div class="topbar">
			<div class="logo">MangaBango</div>
			<div class="search_wrap">
				<input class="search_box" type="text" autocomplete="off" />
			</div>
		</div>
		<div class="sidebar">
			<div class="button">
				<a href="/displaylibrary">
					<img src="\resources\icons\bookshelf.svg" />
				</a>
			</div>
			<div class="button">
				<a href="/config">
					<img src="\resources\icons\gears.svg" />
				</a>
			</div>
			<div class="button">
				<a href="/db/dashboard">
					<img src="\resources\icons\database.svg" />
				</a>
			</div>
		</div>
		<div class="display_container">';

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

if (!empty($current_segs)) {
	if ($current_segs[0] === 'ajax') {
		// If the first segment is ajax, pass the rest of the data to the ajax
		// controller so it can decide what methods to run.
		unset ($current_segs[0]);
		$current_segs = array_values ($current_segs);
		
		$ajax = new AJAXProcessor ($current_segs);
		$ajax->fireTargetMethod ();
	} else if ($current_segs[0] === 'db') {
		// Use the DBViewer files
		$namespace = '\DBViewer\PageControllers';
		for ($i = 1; $i < count ($current_segs); $i++) {
			$namespace .= '\\'.$current_segs[$i];
		}
		
		try {
			new $namespace ();
		} catch (Error $e) {
			echo $e->getMessage ();
		}
	} else {
		$namespace = '\Controllers';
		
		for ($i = 0; $i < count ($current_segs); $i++) {
			$namespace .= '\\'.$current_segs[$i];
		}
		
		try {
			new $namespace ();
		} catch (Error $e) {
			echo $e->getMessage ();
		}
	}
} else {
	// Empty so its just the home page.
	new \Controllers\Home ();
}

echo 
		'</div>
	</body>
</html>';

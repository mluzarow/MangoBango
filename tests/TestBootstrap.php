<?php
declare (strict_types = 1);

// Autoload classes based on a 1:1 mapping from namespace to directory structure.
spl_autoload_register(function ($className) {
	$ds = DIRECTORY_SEPARATOR;
	$dir = str_replace ("{$ds}tests", "{$ds}app", __DIR__);
	
	// Replace namespace separator with directory separator
	$className = str_replace('\\', $ds, $className);
	
	// Get full name of file containing the required class
	$file = "{$dir}{$ds}{$className}.php";
	
	// Get file if it is readable
	if (is_readable ($file)) {
		require_once $file;
	}
});

// Include the static providers as well
require_once __DIR__.DIRECTORY_SEPARATOR.'DataProviders.php';

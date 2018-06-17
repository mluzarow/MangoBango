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
		echo 'Not Implemented.';
	}
} else {
	// Empty so its just the home page.
	echo '
		<head>
			<script type="text/javascript" src="http://69.47.79.25:6969/External/Javascript/jquery-3.3.1.js"></script>
		</head>
		<body>
		<a class="db_button" href="http://69.47.79.25:6969/db/dashboard">
			DB
		</div>
		<style>
			.db_button {
				padding: 9px;
				width: 100px;
				height: 40px;
				display: block;
				background-color: #000;
				box-sizing: border-box;
				color: #fff;
				cursor: pointer;
				text-align: center;
				text-decoration: none;
			}
		</style>
		</body>';
}


// <script>
// 	$(window).ready (function () {
// 		$(".db_button").click (function () {
// 			$.ajax ({
// 				url: "ajax/Controllers/ConfigDisplay/ajaxProcessConfigs",
// 				data: {test : "test_data"},
// 				type: "post",
// 				success: function () {
// 					console.log ("Successful ajax!");
// 				}
// 			});
// 		});
// 	});
// </script>


// 
// if ($db->connect_errno) {
// 	echo 'DB connection error.';
// 	echo "Errno: " . $db->connect_errno . "\n";
//     echo "Error: " . $db->connect_error . "\n";
// 	exit;
// }
// 
// $q = "SELECT * FROM `server_configs`";
// $r = $db->query ($q);
// 
// if ($r === false) {
// 	echo 'Failed';
// }
// 
// $configs = [];
// while ($config = $r->fetch_assoc()) {
// 	$configs[$config['config_name']] = $config['config_value'];
// }
// 
// print_r($configs);

// $test_page = new Displaylibrary ();

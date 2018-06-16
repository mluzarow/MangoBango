<?php
// use Controllers\Displaylibrary;
// use DBViewer\Controller\DBViewerMain;
use \Core\AJAXProcessor;

// autoload classes based on a 1:1 mapping from namespace to directory structure.
spl_autoload_register(function ($className) {
	# Usually I would just concatenate directly to $file variable below
	# this is just for easy viewing on Stack Overflow)
	$ds = DIRECTORY_SEPARATOR;
	$dir = __DIR__;
	
	// replace namespace separator with directory separator (prolly not required)
	$className = str_replace('\\', $ds, $className);
	
	// get full name of file containing the required class
	$file = "{$dir}{$ds}{$className}.php";
	echo $file;
	// get file if it is readable
	if (is_readable($file)) {
		require_once $file;
	}
});

// Parse the URL here
$current_segs = trim($_SERVER['REQUEST_URI'], '/');
$current_segs = explode ('/', $current_segs);

if (count ($current_segs) === 1) {
	if (empty ($current_segs[0])) {
		unset ($current_segs[0]);
		$current_segs = array_values ($current_segs);
		print_r($current_segs);
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
		exit;
	}
} else {
	// Empty so its just the home page.
	echo '
		<head>
			<script type="text/javascript" src="http://69.47.79.25:6969/External/Javascript/jquery-3.3.1.js"></script>
		</head>
		<body>
		<div class="db_button">
			DB
		</div>
		<style>
			.db_button {
				width: 100px;
				height: 40px;
				background-color: #000;
				color: #fff;
				cursor: pointer;
				text-align: center;
				box-sizing: border-box;
				padding: 9px;
			}
		</style>
		<script>
			$(window).ready (function () {
				$(".db_button").click (function () {
					$.ajax ({
						url: "ajax/Controllers/ConfigDisplay/ajaxProcessConfigs",
						data: {test : "test_data"},
						type: "post",
						success: function () {
							console.log ("Successful ajax!");
						}
					});
				});
			});
		</script>
		</body>';
}




// $db = new mysqli ('localhost:3306', 'root', 'glitch123', 'server');
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

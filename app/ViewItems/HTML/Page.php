<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $view->getTitle (); ?></title>
		<link rel="stylesheet" type="text/css" href="/External/FontAwesome/css/fontawesome-5.10.2.min.css">
		<?php echo $view->getViewContent ()->getCSS (); ?>
		<script type="text/javascript" src="/External/Javascript/jquery-3.3.1.js"></script>
		<?php echo $view->getViewContent ()->getJS (); ?>
	</head>
	<body>
		<?php echo $view->getViewContent ()->getHTML (); ?>
	</body>
</html>

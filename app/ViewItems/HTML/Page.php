<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $view->getTitle (); ?></title>
		<?php echo $view->getViewContent ()->getCSS (); ?>
		<script type="text/javascript" src="/External/Javascript/jquery-3.3.1.js"></script>
		<?php echo $view->getViewContent ()->getJS (); ?>
	</head>
	<body>
		<?php echo $view->getViewContent ()->getHTML (); ?>
	</body>
</html>

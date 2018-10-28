<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $view->getTitle (); ?></title>
		<?php echo $view->getViewContents ()->getCSS (); ?>
		<script type="text/javascript" src="/External/Javascript/jquery-3.3.1.js"></script>
		<?php echo $view->getViewContents ()->getJS (); ?>
	</head>
	<body>
		<?php echo $view->getViewContents ()->getHTML (); ?>
	</body>
</html>

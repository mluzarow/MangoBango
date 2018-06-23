<?php
namespace Controllers;

class Home {
	public function __construct () {
		$view = new \ViewItems\PageViews\HomeView ([]);
		echo $view->render ();
	}
}

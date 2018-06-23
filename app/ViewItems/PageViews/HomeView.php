<?php
namespace ViewItems\PageViews;

use ViewItems\ViewAbstract;

class HomeView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<style>
			.db_button {
				margin: 5px;
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
		</style>';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<a class="db_button" href="/db/dashboard">DB</a>
		<a class="db_button" href="/displaylibrary">Library</a>
		<a class="db_button" href="/config">Config</a>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
	}
}

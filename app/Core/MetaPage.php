<?php
namespace Core;

/**
 * Meta page view which collects all other views together in the correct order.
 */
class MetaPage {
	/**
	 * @var string page header content
	 */
	private static $head = '';
	/**
	 * @var string page HTML
	 */
	private static $body = '';
	
	/**
	 * Appends the given HTML to the HTML to be printed.
	 * 
	 * @param string $html page HTML
	 */
	public static function appendBody ($html) {
		$body_halves = explode ('{appendHere}', self::$body);
		
		$body_halves[0] .= $html;
		
		self::$body = implode ('{appendHere}', $body_halves);
	}
	
	/**
	 * Appends the script or styling to the page header content.
	 * 
	 * @param string $content script or css to append
	 */
	public static function appendHead ($content) {
		self::$head .= $content;
	}
	
	/**
	 * Renders the page.
	 * 
	 * @return string entirety of page content
	 */
	public static function render () {
		$output =
		'<!DOCTYPE html>
		<html>
			<head>
				'.self::$head.'
			</head>
			<body>
				'.str_replace ('{appendHere}', '', self::$body).'
			</body>
		</html>';
		
		return ($output);
	}
}

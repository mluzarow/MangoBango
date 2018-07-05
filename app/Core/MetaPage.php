<?php
namespace Core;

/**
 * Meta page view which collects all other views together in the correct order.
 */
class MetaPage {
	/**
	 * @var string page HTML
	 */
	private static $body = '';
	/**
	 * @var string page header content
	 */
	private static $head = '';
	/**
	 * @var string page title
	 */
	private static $title = '';
	
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
				<title>'.self::$title.'</title>
				'.self::$head.'
			</head>
			<body>
				'.str_replace ('{appendHere}', '', self::$body).'
			</body>
		</html>';
		
		return ($output);
	}
	
	/**
	 * Overwrites the body with given HTML.
	 * 
	 * @param string $body body HTML
	 */
	public static function setBody ($body) {
		self::$body = $body;
	}
	
	/**
	 * Overwrites the head with given HTML.
	 * 
	 * @param string $head head HTML
	 */
	public static function setHead ($head) {
		self::$head = $head;
	}
	
	/**
	 * Sets the page title.
	 * 
	 * @param string $title page title
	 */
	public static function setTitle ($title) {
		self::$title = $title;
	}
}

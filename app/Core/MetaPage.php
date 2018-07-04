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
		self::$body .= $html;
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
				<script type="text/javascript" src="/External/Javascript/jquery-3.3.1.js"></script>
				<script type="text/javascript" src="/ViewItems/JS/dropdown.js"></script>
				<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/UIFrame.css">
				'.self::$head.'
			</head>
			<body>
				<div class="topbar">
					<div class="logo">
						<a href="\">MangoBango</a>
					</div>
					<div class="icons_wrap">
						<div class="button btn_burger dropdown_menu_button">
							<img src="\resources\icons\burger.svg" />
						</div>
						<div class="burger_dropdown dropdown_menu">
							<div class="menu_item">
								<a href="/import">
									<img src="\resources\icons\upload.svg" />
									<span>Importer</span>
								</a>
							</div>
							<div class="menu_item">
								<a href="/displaylibrary">
									<img src="\resources\icons\bookshelf.svg" />
									<span>Library</span>
								</a>
							</div>
							<div class="menu_item">
								<a href="/config">
									<img src="\resources\icons\gears.svg" />
									<span>Settings</span>
								</a>
							</div>
							<div class="menu_item">
								<a href="/db/dashboard">
									<img src="\resources\icons\database.svg" />
									<span>Database</span>
								</a>
							</div>
						</div>
						<div class="button btn_import">
							<a href="/import">
								<img src="\resources\icons\upload.svg" />
							</a>
						</div>
						<div class="button btn_library">
							<a href="/displaylibrary">
								<img src="\resources\icons\bookshelf.svg" />
							</a>
						</div>
						<div class="flyout library">
							<div class="search_wrap">
								<input class="search_box" type="text" autocomplete="off" />
							</div>
						</div>
						<div class="button btn_config">
							<a href="/config">
								<img src="\resources\icons\gears.svg" />
							</a>
						</div>
						<div class="button btn_db">
							<a href="/db/dashboard">
								<img src="\resources\icons\database.svg" />
							</a>
						</div>
					</div>
				</div>
				<div class="display_container">
					'.self::$body.'
				</div>
			</body>
		</html>';
		
		return ($output);
	}
}

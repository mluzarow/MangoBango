<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewAbstract;

/**
 * Meta page view rendering the page frame.
 */
class MetaView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/UIFrame.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="topbar">
			<div class="logo">
				<a href="\">MangoBango</a>
			</div>
			<div class="icons_wrap">
				<div class="button btn_burger dropdown_menu_button">
					<img src="\resources\icons\burger.svg" />
				</div>
				<div class="burger_dropdown dropdown_menu">
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
			{appendHere}
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		$output =
		'<script type="text/javascript" src="/External/Javascript/jquery-3.3.1.js"></script>
		<script type="text/javascript" src="/ViewItems/JS/dropdown.js"></script>';
		
		return ($output);
	}
}
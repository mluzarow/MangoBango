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
					<div class="menu_item login_wrap_mobile">
						<div class="login_text">
							<span>Logged in as</span>
							<span class="login_name">'.$this->getUsername ().'</span>
						</div>
						<div class="logout_btn">Log Out</div>
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
				<div class="login_wrap">
					<div class="login_text">
						<span>Logged in as</span>
						<span class="login_name">'.$this->getUsername ().'</span>
					</div>
					<div class="dropdown_menu_button expand_arrow">▾</div>
					<div class="dropdown_menu">
						<div class="logout_btn">Log Out</div>
					</div>
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
		<script type="text/javascript" src="/ViewItems/JS/dropdown.js"></script>
		<script type="text/javascript" src="/ViewItems/JS/logout.js"></script>';
		
		return ($output);
	}
	
	protected function setUsername (string $username) {
		$this->username = $username;
	}
	
	private function getUsername () {
		return ($this->username);
	}
}
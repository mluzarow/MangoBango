<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewAbstract;

/**
 * View class for the list of server configs on the config page.
 */
class ConfigView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/Config.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="config_list_wrap">
			<h2 class="title">Server Settings</h2>
			<form class="config_list">
				<div class="config_wrap">
					<label>Reader Display Style</label>
					<select id="reader_display_style" autocomplete="off">
						<option value="1" '.($this->getReaderDisplayStyle () === 1 ? 'selected' : '').'>Display as single panel</option>
						<option value="2" '.($this->getReaderDisplayStyle () === 2 ? 'selected' : '').'>Display as continous strip</option>
					</select>
				</div>
				<div class="config_wrap">
					<label>Manga directory</label>
					<input id="manga_directory" value="'.$this->getMangaDirectory ().'" type="text" autocomplete="off" />
				</div>
				<div class="config_wrap">
					<label>Library Display Style</label>
					<select id="library_view_type" autocomplete="off">
						<option value="1" '.($this->getLibraryViewType () === 1 ? 'selected' : '').'>Display as covers</option>
						<option value="2" '.($this->getLibraryViewType () === 2 ? 'selected' : '').'>Display as bookcase</option>
					</select>
				</div>
			</form>
			<div class="submit_btn">Save</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		$output =
		'<script type="text/javascript" src="/ViewItems/JS/Config.js"></script>';
		
		return ($output);
	}
	
	/**
	 * Gets the library view type.
	 * 
	 * @return int library view type
	 */
	protected function getLibraryViewType () {
		return ($this->library_view_type);
	}
	
	/**
	 * Gets the manga directory setting.
	 * 
	 * @return string manga directory setting
	 */
	protected function getMangaDirectory () {
		return ($this->manga_directory);
	}
	
	/**
	 * Gets the reader display style setting.
	 * 
	 * @return int reader display style setting
	 */
	protected function getReaderDisplayStyle () {
		return ($this->reader_display_style);
	}
	
	/**
	 * Sets the library view type.
	 * 
	 * @param int $config library view type
	 * 
	 * @throws TypeError on non-int config value
	 * @throws InvalidArgumentException on config value out of bounds
	 */
	protected function setLibraryViewType (int $config) {
		if (!in_array($config, [1, 2])) {
			throw new \InvalidArgumentException ('Argument (Library View Type) value must in set [1, 2]; '.$config.' given.');
		}
		
		$this->library_view_type = $config;
	}
	
	/**
	 * Sets the manga directory setting.
	 * 
	 * @param string $config manga directory setting
	 *
	 * @throws TypeError on non-string config value
	 * @throws InvalidArgumentException on empty config value
	 */
	protected function setMangaDirectory (string $config) {
		$config = trim ($config);
		
		if (empty ($config)) {
			throw new InvalidArgumentException ('Argument (Manga Directory) can not be empty.');
		}
		
		$this->manga_directory = $config;
	}
	
	/**
	 * Sets the reader display style setting.
	 * 
	 * @param int $config reader display style setting
	 * 
	 * @throws TypeError on non-integer config value
	 * @throws InvalidArgumentException on config value out of bounds
	 */
	protected function setReaderDisplayStyle (int $config) {
		if (!in_array($config, [1, 2])) {
			throw new \InvalidArgumentException ('Argument (Reader Display Style) value must in set [1, 2]; '.$config.' given.');
		}
		
		$this->reader_display_style = $config;
	}
}

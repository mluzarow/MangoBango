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
		return ('');
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		return ('');
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
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
	 * Sets the reader display style setting.
	 * 
	 * @param int $config reader display style setting
	 * 
	 * @throws InvalidArgumentException on config value out of bounds
	 */
	protected function setReaderDisplayStyle (int $config) {
		if (!in_array($config, [1, 2])) {
			throw new \InvalidArgumentException ('Argument (Reader Display Style) value must in set [1, 2]; '.$config.' given.');
		}
		
		$this->reader_display_style = $config;
	}
}

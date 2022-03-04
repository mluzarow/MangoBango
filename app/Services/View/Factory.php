<?php
declare (strict_types = 1);

namespace Services\View;

use Services\View\Data\IViewData;
use Services\View\Data\ViewItem;

/**
 * View item factory.
 */
class Factory {
	/**
	 * Builds the requested view's data object.
	 * 
	 * @param  string $name       name of view data object
	 * @param  array  $parameters view data parameter dictionary
	 * 
	 * @return IViewData view data object
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	public function buildViewData (string $name, array $parameters) : IViewData {
		ksort ($parameters);
		$parameters = array_values ($parameters);
		
		$namespace = "\\Services\\View\\Data\\{$name}";
		
		if (class_exists($namespace) === false) {
			// No specific data object exists so use the default one
			$namespace = "\\Services\\View\\Data\\ViewData";
			
			return new $namespace ($parameters);
		} else {
			return new $namespace (... $parameters);
		}
	}
	
	/**
	 * Builds view item data object.
	 * 
	 * @param  array  $css  list of CSS tags
	 * @param  string $html HTML output
	 * @param  array  $js   list of JS tags
	 * 
	 * @return ViewItem view data object
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	public function buildViewItem (
		array $css,
		string $html,
		array $js
	) : ViewItem {
		return new ViewItem ($css, $html, $js);
	}
}

<?php
namespace ViewItems\PageViews;

use ViewItems\ViewAbstract;

/**
 * View class displaying volume covers of a given series.
 */
class DisplaySeriesView extends ViewAbstract {
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
	 * Sets display data for each volume.
	 *
	 * Uses the following array structure:
	 * array
	 *   ├── [0]
	 *   │    ├── ['link']    string  href reader link for the manga volume
	 *   │    └── ['source']  string  image source for the volume cover
	 *   │    .
	 *   │    .
	 *   └── [n]
	 * 
	 * @param array $volumes display data for each volume
	 * 
	 * @throws TypeError on non-array parameter
	 * @throws InvalidArgumentException on:
	 *         - non-array items
	 *         - missing array item keys
	 *         - non string array items
	 *         - empty array items
	 */
	protected function setVolumes (array $volumes) {
		foreach ($volumes as $volume) {
			if (!is_array ($volume)) {
				throw new InvalidArgumentException ('Argument (Volumes) items must be of type array.');
			}
			
			foreach (['link', 'source'] as $key) {
				if (!array_key_exists ($key, $volume)) {
					throw new InvalidArgumentException ("Argument (Volumes) items must have key \"{$key}\"");
				}
				
				if (!is_string ($volume[$key])) {
					throw new InvalidArgumentException ("Argument (Volumes) items key \"{$key}\" must be of type string.");
				}
			}
		}
		
		$this->volumes = $volumes;
	}
	
	/**
	 * Gets display data for each volume.
	 * 
	 * @return array display data for each volume
	 */
	private function getVolumes () {
		return ($this->volumes);
	}
}

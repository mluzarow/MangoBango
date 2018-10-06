<?php
namespace ViewItems\PageViews;

use ViewItems\ViewTemplate;

class HomeView extends ViewTemplate {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/Home.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<h2 class="home_header">Library Statistics</h2>
		<div class="statbox_grid_display">';
			foreach ($this->getBoxContents() as $box) {
				$output .=
				'<div class="statbox_wrap">
					<div class="title">'.$box['title'].'</div>
					<div class="statbox_inner_wrap">
						<span>'.$box['value'].'</span>
					</div>
				</div>';
			}
		$output .=
		'</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
	}
	
	/**
	 * Gets the box contents list.
	 * 
	 * @return array box contents list
	 */
	protected function getBoxContents () {
		return ($this->box_contents);
	}
	
	/**
	 * Set the box contents list.
	 * 
	 * @param array $box_contents box contents list
	 * 
	 * @throws TypeError on non-array parameter
	 * @throws InvalidArgumentException on non-array items or missing item keys
	 */
	protected function setBoxContents (array $box_contents) {
		foreach ($box_contents as $box) {
			if (!is_array($box)) {
				throw new \InvalidArgumentException('Argument (Box Contents) items must be arrays; '.gettype ($box).' given.');
			}
			
			if (!array_key_exists ('title', $box)) {
				throw new \InvalidArgumentException('Argument (Box Contents) items must have key "title".');
			}
			if (!array_key_exists ('value', $box)) {
				throw new \InvalidArgumentException('Argument (Box Contents) items must have key "value".');
			}
		}
		
		$this->box_contents = $box_contents;
	}
}

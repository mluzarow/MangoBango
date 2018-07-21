<?php
namespace ViewItems\Partial;

use \ViewItems\ViewAbstract;

/**
 * Partial view class for statistics box displaying text.
 */
class StatboxTextView implements ViewAbstract {
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
		$output =
		'<div class="statbox_wrap">
			<div class="title">'.$this->getTitle().'</div>
			<div class="statbox_inner_wrap">
				<span>'.$this->getValue().'</span>
			</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
	}
	
	/**
	 * Gets the statbox title.
	 * 
	 * @return string statbox title
	 */
	protected function getTitle () {
		return ($this->title);
	}
	
	/**
	 * Gets the statbox value.
	 * 
	 * @return string statbox value
	 */
	protected function getValue () {
		return ($this->value);
	}
	
	/**
	 * Set the statbox title.
	 * 
	 * @param string $title statbox title
	 * 
	 * @throws TypeError on non-string parameter
	 * @throws InvalidArgumentException on empty parameter
	 */
	protected function setTitle (string $title) {
		$title = trim ($title);
		
		if (empty ($title)) {
			throw new \InvalidArgumentException('Argument (Title) must not be empty.');
		}
		
		$this->title = $title;
	}
	
	/**
	 * Set the statbox value.
	 * 
	 * @param string $value statbox value
	 * 
	 * @throws TypeError on non-string parameter
	 * @throws InvalidArgumentException on empty parameter
	 */
	protected function setValue (string $value) {
		$value = trim ($value);
		
		if (empty ($value)) {
			throw new \InvalidArgumentException('Argument (Value) must not be empty.');
		}
		
		$this->value = $value;
	}
}

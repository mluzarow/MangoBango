<?php
declare (strict_types = 1);

namespace ViewItems\Common\Data;

use ViewItems\View; 
use ViewItems\ViewData;

/**
 * Collection of views.
 */
class ViewCollection extends ViewData implements \Iterator  {
	/**
	 * @var array list of views
	 */
	private $views;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param array $views list of views
	 * 
	 * @throws TypeError on invalid parameter types
	 */
	public function __construct (array $views) {
		$this->setViews ($views);
	}
	
	/**
	 * Gets the current value on which the iterator is currently.
	 * 
	 * @return mixed current iterator value
	 */
	public function current () {
		return current ($this->views);
	}
	
	/**
	 * Gets the key of the current iterator value.
	 * 
	 * @return string|int key of the current iterator value
	 */
	public function key () {
		return key ($this->views);
	}
	
	/**
	 * Advances the internal array pointer one place forward & returns that
	 * value being pointed to, or false if no value.
	 * 
	 * @return mixed|false next value or false if no value
	 */
	public function next () {
		return next ($this->views);
	}
	
	/**
	 * Resets iterator to first value.
	 * 
	 * @return mixed first iterator value
	 */
	public function rewind () {
		return reset ($this->views);
	}
	
	/**
	 * Checks if current iterator value exists.
	 * 
	 * @return bool iterator value status
	 */
	public function valid () {
		return key ($this->views) !== null;
	}
	
	/**
	 * Sets list of views.
	 * 
	 * @param array $views list of views
	 * 
	 * @throws TypeError on non-array parameter or non-View items
	 */
	private function setViews (array $views) {
		foreach ($views as $view) {
			$this->checkIsType (View::class, 'Views > View', $view);
		}
		
		$this->views = $views;
	}
}

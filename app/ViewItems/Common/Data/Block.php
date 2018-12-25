<?php
declare (strict_types = 1);

namespace ViewItems\Common\Data;

use ViewItems\ViewData;

/**
 * Data object for Block view.
 */
class Block extends ViewData {
	/**
	 * @var string         $title           block heading
	 * @var ViewCollection $view_collection view collection
	 */
	private $title;
	private $view_collection;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param string         $title           block heading
	 * @param ViewCollection $view_collection view collection
	 * 
	 * @throws InvalidArgumentException on invalid parameter structure
	 * @throws TypeError on invalid parameter or return
	 */
	public function __construct (string $title, ViewCollection $view_collection) {
		$this->setTitle ($title);
		$this->setViewCollection ($view_collection);
	}
	
	/**
	 * Gets block heading.
	 * 
	 * @return string block heading
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getTitle () : string {
		return $this->title;
	}
	
	/**
	 * Gets view collection.
	 * 
	 * @return ViewCollection view collection
	 * 
	 * @throws TypeError on non-ViewCollection return
	 */
	public function getViewCollection () : ViewCollection {
		return $this->view_collection;
	}
	
	/**
	 * Sets block heading.
	 * 
	 * @param string $title block heading
	 * 
	 * @throws InvalidArgumentException on empty parameter
	 * @throws TypeError on non-string parameter
	 */
	private function setTitle (string $title) {
		$title = trim ($title);
		
		$this->checkNotEmpty ('Title', $title);
		
		$this->title = $title;
	}
	
	/**
	 * Sets view collection.
	 * 
	 * @param ViewCollection $view_collection view collection
	 * 
	 * @throws TypeError on non-ViewCollection parameter
	 */
	private function setViewCollection (ViewCollection $view_collection) {
		$this->view_collection = $view_collection;
	}
}

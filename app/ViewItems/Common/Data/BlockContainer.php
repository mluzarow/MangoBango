<?php
declare (strict_types = 1);

namespace ViewItems\Common\Data;

use ViewItems\ViewData;

/**
 * Data object for Block container view.
 */
class BlockContainer extends ViewData {
	/**
	 * @var string          $title            heading
	 * @var BlockCollection $block_collection Block collection
	 */
	private $title;
	private $block_collection;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param string          $title            heading
	 * @param BlockCollection $block_collection Block collection
	 * 
	 * @throws InvalidArgumentException on invalid parameter structure
	 * @throws TypeError on invalid parameter or return
	 */
	public function __construct (string $title, BlockCollection $block_collection) {
		$this->setTitle ($title);
		$this->setBlockCollection ($block_collection);
	}
	
	/**
	 * Gets heading.
	 * 
	 * @return string heading
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getTitle () : string {
		return $this->title;
	}
	
	/**
	 * Gets Block collection.
	 * 
	 * @return BlockCollection Block collection
	 * 
	 * @throws TypeError on non-BlockCollection return
	 */
	public function getBlockCollection () : BlockCollection {
		return $this->block_collection;
	}
	
	/**
	 * Sets heading.
	 * 
	 * @param string $title heading
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
	 * Sets Block collection.
	 * 
	 * @param BlockCollection $block_collection Block collection
	 * 
	 * @throws TypeError on non-BlockCollection parameter
	 */
	private function setBlockCollection (BlockCollection $block_collection) {
		$this->block_collection = $block_collection;
	}
}

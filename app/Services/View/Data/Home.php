<?php
declare (strict_types = 1);

namespace Services\View\Data;

/**
 * View data object for the Home view.
 */
class Home implements IViewData {
	/**
	 * @var array box contents list
	 */
	private $box_contents;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param array $box_contents box contents list
	 * 
	 * @throws TypeError on non-array parameter
	 */
	public function __construct (array $box_contents) {
		$this->setBoxContents ($box_contents);
	}
	
	/**
	 * Gets the box contents list.
	 * 
	 * @return array box contents list
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getBoxContents () : array {
		return $this->box_contents;
	}
	
	/**
	 * Gets the view name to which the data is tied (the controller's name).
	 * 
	 * @return string page controller name
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getViewName () : string {
		return 'Home';
	}
	
	/**
	 * Set the box contents list.
	 * 
	 * @param array $box_contents box contents list
	 * 
	 * @throws TypeError on non-array parameter
	 * @throws InvalidArgumentException on non-array items or missing item keys
	 */
	private function setBoxContents (array $box_contents) {
		foreach ($box_contents as $i => $box) {
			if (!is_array($box)) {
				throw new \InvalidArgumentException(
					"Parameter (Box Contents > {$i}) must be of type array; ".
					gettype ($box).' given.'
				);
			}
			
			if (!array_key_exists ('title', $box)) {
				throw new \InvalidArgumentException(
					"Parameter (Box Contents > {$i}) must have key \"title\"."
				);
			}
			if (!array_key_exists ('value', $box)) {
				throw new \InvalidArgumentException(
					"Parameter (Box Contents > {$i}) must have key \"value\"."
				);
			}
		}
		
		$this->box_contents = $box_contents;
	}
}

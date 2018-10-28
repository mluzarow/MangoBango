<?php
namespace Services\View\Data;

/**
 * Data structure holding general view data.
 */
class ViewItem {
	/**
	 * Constructor for view item data structure.
	 * 
	 * @param array  $css  list of CSS tags
	 * @param string $html HTML content
	 * @param array  $js   list of JS tags
	 * 
	 * @throws TypeError on invalid parameter type
	 */
	public function __construct (array $css, string $html, array $js) {
		$this->setCSSTags ($css);
		$this->setHTML ($html);
		$this->setJSTags ($js);
	}
	
	/**
	 * Gets CSS output.
	 * 
	 * @return string CSS output
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getCSS () : string {
		return implode ("\n", $this->css);
	}
	
	/**
	 * Gets list of CSS tags.
	 * 
	 * @return array list of CSS tags
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getCSSTags () : array {
		return $this->css;
	}
	
	/**
	 * Gets HTML output.
	 * 
	 * @return string HTML output
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getHTML () : string {
		return $this->html;
	}
	
	/**
	 * Gets JS output.
	 * 
	 * @return string JS output
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getJS () : string {
		return implode ("\n", $this->js);
	}
	
	/**
	 * Gets list of JS tags.
	 * 
	 * @return array list of JS tags
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getJSTags () : array {
		return $this->js;
	}
	
	/**
	 * Sets CSS tag list.
	 * 
	 * @param array $css CSS tag list
	 * 
	 * @throws InvalidArgumentException on non-string items
	 * @throws TypeError on non-array parameter
	 */
	private function setCSSTags (array $css) {
		foreach ($css as $item) {
			if (!is_string ($item))
				throw new \InvalidArgumentException (
					'Parameter (CSS > n) must be of type string; '.
					gettype ($css).' given.'
				);
		}
		
		$this->css = $css;
	}
	
	/**
	 * Sets HTML.
	 * 
	 * @param string $html HTML output
	 * 
	 * @throws TypeError on non-string parameter
	 */
	private function setHTML (string $html) {
		$this->html = $html;
	}
	
	/**
	 * Sets JS tag list.
	 * 
	 * @param array $js JS tag list
	 * 
	 * @throws InvalidArgumentException on non-string items
	 * @throws TypeError on non-array parameter
	 */
	private function setJSTags (array $js) {
		foreach ($js as $item) {
			if (!is_string ($item))
				throw new \InvalidArgumentException (
					'Parameter (JS > n) must be of type string; '.
					gettype ($js).' given.'
				);
		}
		
		$this->js = $js;
	}
}

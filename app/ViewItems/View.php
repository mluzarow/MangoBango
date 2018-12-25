<?php
declare (strict_types = 1);

namespace ViewItems;

/**
 * Generic view.
 */
class View {
	/**
	 * @var string $output_css  CSS output
	 * @var string $output_html HTML output
	 */
	protected $output_css;
	protected $output_html;
	
	/**
	 * @var ViewData view data object
	 */
	protected $view_data;
	
	/**
	 * Generic view constructor.
	 * 
	 * @param ViewData $view_data view data object
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	public final function __construct (ViewData $view_data) {
		$this->setViewData ($view_data);
	}
	
	/**
	 * Gets CSS output.
	 * 
	 * @return string CSS output
	 * 
	 * @throws TypeError on non-string return
	 */
	public final function getCSS () : string {
		if ($this->output_css === null) {
			$this->output_css = $this->renderCSS ();
		}
		
		// Also check for duplicates here or something I don't know
		
		return $this->output_css;
	}
	
	/**
	 * Gets HTML output.
	 * 
	 * @return string HTML output
	 * 
	 * @throws TypeError on non-string return
	 */
	public final function getHTML () : string {
		if ($this->output_html === null) {
			$this->output_html = $this->renderHTML ();
		}
		
		return $this->output_html;
	}
	
	/**
	 * Gets view data object.
	 * 
	 * @return ViewData view data object
	 * 
	 * @throws TypeError on non-ViewData return
	 */
	protected final function getViewData () : ViewData {
		return $this->view_data;
	}
	
	/**
	 * Sets view data object.
	 * 
	 * @param ViewData $view_data view data object
	 * 
	 * @throws TypeError on non-ViewData parameter
	 */
	private function setViewData (ViewData $view_data) {
		$this->view_data = $view_data;
	}
}

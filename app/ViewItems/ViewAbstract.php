<?php
namespace ViewItems;

use \Core\MetaPage;

/**
 * View class template from which all views extend.
 */
abstract class ViewAbstract {
	/**
	 * @var string CSS output
	 */
	protected $css_output;
	/**
	 * @var string HTML output
	 */
	protected $html_output;
	/**
	 * @var string JS output
	 */
	protected $js_output;
	
	/**
	 * Constructor for view class.
	 * 
	 * @param array $view_parameters dictionary of view class properties. Will
	 *                               dynamically fire setters according to property
	 *                               keys given.
	 * 
	 * @throws TypeError on non-array view_parameters and properties of incorrect
	 *                   type
	 */
	public final function __construct (array $view_parameters) {
		$this->processParameters ($view_parameters);
	}
	
	/**
	 * Saves the view content to the meta page.
	 */
	public final function render () {
		MetaPage::appendHead ($this->getCSS ());
		MetaPage::appendHead ($this->getJS ());
		MetaPage::appendBody ($this->getHTML ());
	}
	
	/**
	 * Processes property dictionary and sets the appropriate propteries.
	 * 
	 * @var array $view_parameters dictionary of view class properties
	 * 
	 * @throws TypeError on non-array view_parameters and properties of incorrect
	 *                   type
	 */
	protected final function processParameters (array $view_parameters) {
		foreach ($view_parameters as $name => $value) {
			$this->$name = null;
			
			$word_segments = explode ('_', $name);
			
			foreach ($word_segments as &$segment) {
				$segment = ucwords ($segment);
			}
			
			$func = 'set'.implode ('', $word_segments);
			$this->$func ($value);
		}
	}
	
	/**
	 * Constructs the CSS using the available properties.
	 */
	abstract protected function constructCSS ();
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	abstract protected function constructHTML ();
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	abstract protected function constructJavascript ();
	
	/**
	 * Gets the CSS output.
	 * 
	 * @return string CSS output
	 */
	private function getCSS () {
		if (empty ($this->css_output)) {
			$this->css_output = $this->constructCSS ();
		}
		
		return ($this->css_output);
	}
	
	/**
	 * Gets the HTML output.
	 * 
	 * @return string HTML output
	 */
	private function getHTML () {
		if (empty ($this->html_output)) {
			$this->html_output = $this->constructHTML ();
		}
		
		return ($this->html_output);
	}
	
	/**
	 * Gets the JS output.
	 * 
	 * @return string JS output
	 */
	private function getJS () {
		if (empty ($this->js_output)) {
			$this->js_output = $this->constructJavascript ();
		}
		
		return ($this->js_output);
	}
}
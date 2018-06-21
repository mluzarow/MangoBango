<?php
namespace ViewItems;

/**
 * View class template from which all views extend.
 */
abstract class ViewAbstract {
	/**
	 * @var string constructed HTML output of view class
	 */
	protected $output;
	
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
		$this->finalizeView ();
	}
	
	/**
	 * Outputs the view HTML.
	 * 
	 * @return string constructed HTML output of view class
	 */
	public final function render () {
		return ($this->output);
	}
	
	/**
	 * Saves view to output so its ready to render.
	 */
	protected final function finalizeView () {
		if (empty($this->output)) {
			$this->output =
				$this->constructCSS ().
				$this->constructHTML ().
				$this->constructJavascript ();
		}
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
			
			$func = 'set'.ucwords (str_replace ('_', '', $name));
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
}
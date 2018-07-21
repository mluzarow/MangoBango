<?php
namespace ViewItems;

/**
 * Partial view class template from which all partial views extend.
 */
abstract class PartialViewAbstract {
	/**
	 * @var string HTML output
	 */
	protected $html_output;
	
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
	 * Gets the partial view output
	 * 
	 * @return string partial view output
	 */
	public final function getOutput () {
		if (empty ($this->html_output)) {
			$this->html_output = $this->constructHTML ();
		}
		
		return ($this->html_output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	abstract protected function constructHTML ();
	
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
}

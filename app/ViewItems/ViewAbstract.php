<?php
namespace ViewItems;

abstract class ViewAbstract {
	protected $output;
	
	abstract protected function constructView ();
	abstract protected function processParameters (array $view_params);
	
	public final function render () {
		return ($this->output);
	}
}
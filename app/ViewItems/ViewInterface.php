<?php
namespace ViewItems;

abstract class ViewInterface {
	protected $error_templates = [
		'InvalidArgumentException' => '%s::%s Argument (%s) must be %s; %s given.'
	];
	protected $output;
	
	abstract protected function constructView ();
	abstract protected function processParameters (array $view_params);
	
	protected final function throwException (Throwable $exception, array $details = null) : null {
		if (!empty($details)) {
			new $$exception (
				vsprintf (
					$error_templates[$exception],
					$details
				)
			);
		} else {
			new $$exception ();
		}
	}
	
	public final function render () {
		return ($this->output);
	}
}
<?php
declare (strict_types = 1);

namespace ViewItems;

class ViewData {
	/**
	 * Checks if given var instance matches given type.
	 * 
	 * @param string $class namespace to check against
	 * @param string $name  given variable's name
	 * @param mixed  $var   variable to check
	 * 
	 * @throws TypeError on:
	 *         - Non-string matching instance
	 *         - Non-string name
	 *         - Var not matching given instance path
	 */
	protected final function checkIsType (string $class, string $name, $var) {
		if (!($var instanceOf $class)) {
			$type = getType ($var);
			
			throw new \TypeError (
				"Parameter ({$name}) must be of type {$class}; {$type} given."
			);
		}
	}
	
	/**
	 * Checks if given var is not empty; if it is, throws exception.
	 * 
	 * @param string $name given variable's name
	 * @param mixed  $var  variable to check
	 * 
	 * @throws InvalidArgumentException on empty variable
	 * @throws TypeError on non-string name
	 */
	protected final function checkNotEmpty (string $name, $var) {
		if (empty ($var))
			throw new \InvalidArgumentException (
				"Parameter ({$name}) must not be empty."
			);
	}
}

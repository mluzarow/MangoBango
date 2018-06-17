<?php
namespace Core;

/**
 * Helper class to deal with debugging.
 */
class Debug {
	/**
	 * Pretty-prints a given variable in an easily readable manner.
	 * 
	 * @param mixed $var variable to be printed
	 */
	public static function prettyPrint ($var) {
		$backtrace = debug_backtrace(1)[0];
		
		$output =
		"<pre>Debug::prettyPrint on line {$backtrace['line']} at {$backtrace['file']}\n";
		
		if (is_array($var)) {
			$output .= print_r($var, true).'</pre>';
		} else {
			$output .= var_dump ($var, true).'</pre>';
		}
		
		echo $output;
	} 
}
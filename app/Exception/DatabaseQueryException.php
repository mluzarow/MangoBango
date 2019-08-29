<?php
namespace Exception;

/**
 * Exception regarding database query failures.
 */
class DatabaseQueryException extends \Exception {
	/**
	 * Construction for exception.
	 *
	 * @param string    $message  message to be printed
	 * @param int       $code     exception code
	 * @param Exception $previous previous exception
	 */
	public function __construct($message, $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}

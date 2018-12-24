<?php
declare (strict_types = 1);

namespace Exception;

/**
 * Unimplemented service exception thrown on requested package service not being
 * implemented in said package.
 */
class UnimplementedService extends \Exception
{
	/**
	 * Constructor for exception.
	 * 
	 * @param string $package_name name of package in question
	 * @param string $service_name name of missing service
	 * 
	 * @throws TypeError on non-string parameters
	 */
	public function __construct(string $package_name, string $service_name) {
		parent::__construct(
			"The requested service [{$service_name}] was not available in the 
			package {$package_name}.",
			6901,
			null
		);
	}
}

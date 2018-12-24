<?php
declare (strict_types = 1);

namespace Services;

/**
 * Core package class.
 */
interface IPackage {
	/**
	 * Starts a given service of the package by name.
	 * 
	 * @param string $service_name name of service to start
	 * 
	 * @return object service class
	 * 
	 * @throws TypeError on non-string parameter or non-object return
	 * @throws UnimplementedService on un-implemented service requested
	 */
	public function startService (string $service_name) : object;
}

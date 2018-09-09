<?php
namespace Common;

/**
 * Interface describing requirements for every available package entry point.
 */
interface IPackage {
	/**
	 * Gets (or builds if not yet available) the requested micro service.
	 * 
	 * @param string $service_name name of service from package
	 * 
	 * @return object instance of requested service
	 * 
	 * @throws Exception on non-implemented service selected
	 */
	public function getService (string $service_name) : object;
}

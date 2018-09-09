<?php
namespace Common\MangaInventory;

use Common\IPackage;
use Core\Database;

/**
 * Package dealing with manga inventory reads and writes to the database.
 */
class Package implements IPackage {
	/**
	 * Builds the requested micro service.
	 * 
	 * @param string   $service_name  name of service from inventory package
	 * @param Database $db_connection database singleton
	 * 
	 * @return object instance of requested service
	 * 
	 * @throws Exception on non-implemented service selected
	 * @throws TypeError on invalid argument type
	 */
	public function getService (
		string $service_name,
		Database $db_connection
	) : object {
		switch ($service_name) {
			case 'read' : return $this->getServiceRead ($db_connection); 
			case 'setup': return $this->getServiceSetup ($db_connection);
			case 'write': return $this->getServiceWrite ($db_connection);
			default: throw new Exception ('NO SERVICE');
		}
	}
	
	/**
	 * Builds the inventory read service.
	 * 
	 * @param Database $db_connection datbase singleton
	 * 
	 * @return Read\Service inventory read service
	 * 
	 * @throws TypeError on invalid argument type
	 */
	private function getServiceRead (Database $db_connection) : Read\Service {
		return new Read\Service (new Read\Provider ($db_connection));
	}
	
	/**
	 * Builds the inventory setup service.
	 * 
	 * @param Database $db_connection datbase singleton
	 * 
	 * @return Setup\Service inventory read service
	 * 
	 * @throws TypeError on invalid argument type
	 */
	private function getServiceSetup (Database $db_connection) : Setup\Service {
		return new Setup\Service (new Setup\Provider ($db_connection));
	}
	
	/**
	 * Builds the inventory write service.
	 * 
	 * @param Database $db_connection datbase singleton
	 * 
	 * @return Write\Service inventory read service
	 * 
	 * @throws TypeError on invalid argument type
	 */
	private function getServiceWrite (Database $db_connection) : Write\Service {
		return new Write\Service (new Write\Provider ($db_connection));
	}
}

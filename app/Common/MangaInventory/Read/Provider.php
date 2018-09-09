<?php
namespace Common\MangaInventory\Read;

/**
 * Provider for manga inventory read service.
 * 
 * @see \Common\MangaInventory\Package for package
 * @see \Common\MangaInventory\Read\Service for service
 */
class Provider {
	/**
	 * @var Database database singleton
	 */
	private $db_connection;
	
	/**
	 * Constructor for read provider.
	 * 
	 * @param Database database singleton
	 * 
	 * @throws TypeError on invalid argument types
	 */
	public function __construct (Database $db_connection) {
		$this->setConnection ($db_connection);
	}
	
	/**
	 * Gets database singleton.
	 * 
	 * @return Database database singleton
	 * 
	 * @throws TypeError on invalid argument types
	 */
	private function getConnection () : Database {
		return $this->db_connection;
	}
	
	/**
	 * Sets database singleton.
	 * 
	 * @param Database database singleton
	 * 
	 * @throws TypeError on invalid argument types
	 */
	private function setConnection (Database $db_connection) {
		$this->db_connection = $db_connection;
	}
}

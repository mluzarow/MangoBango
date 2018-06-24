<?php
namespace Core;

/**
 * Database helper for interacting with the MariaDB database.
 */
class Database {
	/**
	 * @var mysqli current DB connection
	 */
	private static $database;
	
	public static function getConnectionData () {
		$details = [
			'client_info' => self::$database->client_info,
			'client_version' => self::$database->client_version,
			'host_info' => self::$database->host_info,
			'stat' => self::$database->stat,
			'server_info' => self::$database->server_info,
			'server_version' => self::$database->server_version
		];
		
		return ($details);
	}
	
	/**
	 * Initializes the database connection.
	 */
	public static function initialize () {
		self::$database = new \mysqli ('localhost:3306', 'root', 'glitch123', 'server');
	}
	
	/**
	 * Queries the database with the given MySQL string.
	 * 
	 * @param string $q MySQL query string
	 * 
	 * @return array|false list of returned rows or false if query failed
	 */
	public static function query ($q) {
		$r = self::$database->query ($q);
		
		if ($r !== false) {
			$result = [];
			while ($t = $r->fetch_assoc ()) {
				$result[] = $t;
			}
			
			return ($result);
		} else {
			throw new Exception (self::$database->error);
		}
	}
}

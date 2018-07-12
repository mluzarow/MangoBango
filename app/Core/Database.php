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
	 * 
	 * @return bool database status flag
	 */
	public static function initialize () : bool {
		$config_data = parse_ini_file ('../app/server.ini');

		self::$database = new \mysqli (
			$config_data['host'].':'.$config_data['port'],
			$config_data['user'],
			$config_data['password']
			);
		
		$server_active = self::$database->query ('use `server`');
		
		return ($server_active);
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
			if ($r === true) {
				return (true);
			}
			
			$result = [];
			while ($t = $r->fetch_assoc ()) {
				$result[] = $t;
			}
			
			return ($result);
		} else {
			throw new \Exception (self::$database->error);
		}
	}
	
	/**
	 * Sanitizes the given string.
	 * 
	 * @param string $input raw input string
	 * 
	 * @return string sanitized input string
	 */
	public static function sanitize ($input) {
		$sanitized_input = self::$database->real_escape_string ($input);
		
		return ($sanitized_input);
	}
}

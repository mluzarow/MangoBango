<?php
declare (strict_types = 1);

namespace Core;

use Exception\DatabaseInitException;
use Exception\DatabaseQueryException;

/**
 * Database helper for interacting with the MariaDB database.
 */
class Database {
	/**
	 * @var string database setup ini file.
	 */
	const DB_INI = '../app/server.ini';
	
	/**
	 * @var Database instance of database connection
	 */
	private static $instance;
	
	/**
	 * @var \SQLite3 $connection database connection
	 * @var string   $db_path    database hostname
	 */
	private $connection;
	private $db_path;
	
	/**
	 * Gets the instance of the database controller.
	 * 
	 * @return Database database controller
	 */
	public static function getInstance () {
		if (self::$instance === null) {
			self::$instance = new \Core\Database ();
			self::$instance->initialize ();
			
		}
		
		return self::$instance;
	}
	
	/**
	 * Gets the database connection information.
	 * 
	 * @return array connection information
	 */
	public function getConnectionData () {
		return [
			'client_info' => $this->connection->client_info,
			'client_version' => $this->connection->client_version,
			'host_info' => $this->connection->host_info,
			'stat' => $this->connection->stat,
			'server_info' => $this->connection->server_info,
			'server_version' => $this->connection->server_version
		];
	}
	
	/**
	 * Query via prepared statement q with parameters defined in params.
	 * 
	 * @param string $q      query string
	 * @param array  $params dictionary of query parameters
	 * 
	 * @return array|true list of returned rows or success flag
	 * 
	 * @throws DatabaseQueryException on failed query
	 */
	public function execute (string $q, array $params) {
		$s = $this->connection->prepare ($q);
		
		if ($s === false) {
			throw new DatabaseQueryException (
				'Failed to prepare query. Error message: '.
				$this->connection->error
			);
		}
		
		foreach ($params as $var_name => $value) {
			if (is_int ($value)) {
				$type = SQLITE3_INTEGER;
			} elseif (is_null($value)) {
				$type = SQLITE3_NULL;
			} else {
				$type = SQLITE3_TEXT;
			}
			
			$p = $s->bindParam (':'.$var_name, $value, $type);
			
			if ($p === false) {
				throw new DatabaseQueryException (
					"Failed to bind parameter {$var_name}. Error message: ".
					$this->connection->error
				);
			}
		}
		
		$r = $s->execute ();
		
		if ($r === false) {
			throw new DatabaseQueryException (
				'Database query failed. Error message: '.$this->connection->error
			);
		}
		
		if ($r === true) {
			return true;
		}
		
		$data = [];
		while ($row = $r->fetchArray (SQLITE3_ASSOC)) {
			$data[] = $row;
		}
		
		return $data;
	}
	
	/**
	 * Queries the database with the given MySQL string.
	 * 
	 * @param string $q MySQL query string
	 * 
	 * @return array|true list of returned rows or success flag
	 * 
	 * @throws DatabaseQueryException on failed query
	 */
	public function query (string $q) {
		$r = $this->connection->query ($q);
		
		if ($r === false)
			throw new DatabaseQueryException (
				'Database query failed. Error message: '.$this->connection->error
			);
		
		if ($r === true)
			return true;
		
		$data = [];
		while ($row = $r->fetchArray (SQLITE3_ASSOC)) {
			$data[] = $row;
		}
		
		return $data;
	}
	
	public function getLastIndex () {
		return $this->connection->insert_id;
	}
	
	/**
	 * Sanitizes the given string.
	 * 
	 * @param string $input raw input string
	 * 
	 * @return string sanitized input string
	 */
	public function sanitize (string $input) : string {
		return $this->connection->real_escape_string ($input);
	}
	
	/**
	 * Constructor for database controller.
	 * 
	 * @throws \IOException on missing server ini file
	 */
	private function __construct () {
		$config_data = parse_ini_file (self::DB_INI);
		
		if (empty($config_data))
			throw new \IOException ('Missing server ini file at '.DB_INI);
		
		$this->db_path = empty($config_data['path']) ? '' : $config_data['path'];
	}
	
	/**
	 * Initialized database connection.
	 * 
	 * @throws DatabaseInitException on DB initialization failure
	 */
	private function initialize () {
		if (empty($this->db_path))
			throw new DatabaseInitException (
				'Path to database file not provided.'
			);
		
		$full_path = rtrim ($this->db_path, DIRECTORY_SEPARATOR).
			DIRECTORY_SEPARATOR.'database.db';
		
		try {
			$this->connection = new \SQLite3 ($full_path);
		} catch (\Exception $e) {
			throw new DatabaseInitException (
				"Failed to open database file at {$full_path}. ".
				'SQLite3 message: '.$e->getMessage()
			);
		}
	}
}

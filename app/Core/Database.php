<?php
declare (strict_types = 1);

namespace Core;

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
	 * @var mysqli $connection database connection
	 * @var string $host       database hostname
	 * @var string $password   database password
	 * @var string $port       database port number
	 * @var string #user       database username
	 */
	private $connection;
	private $host;
	private $password;
	private $port;
	private $user;
	
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
	 * Queries the database with the given MySQL string.
	 * 
	 * @param string $q MySQL query string
	 * 
	 * @return array|true list of returned rows or success flag
	 * 
	 * @throws Exception on failed query
	 */
	public function query (string $q) {
		$r = $this->connection->query ($q);
		
		if ($r === false)
			throw new \Exception ($this->connection->error);
		
		if ($r === true)
			return true;
		
		$result = [];
		while ($item = $r->fetch_assoc ())
			$result[] = $item;
		
		return $result;
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
	 */
	private function __construct () {
		$config_data = parse_ini_file (self::DB_INI);
		
		if (empty($config_data))
			throw new \IOException ('NO INI FILE');
		
		$this->host = $config_data['host'];
		$this->password = $config_data['password'];
		$this->port = $config_data['port'];
		$this->user = $config_data['user'];
	}
	
	/**
	 * Initialized database connection.
	 * 
	 * @uses \mysqli to instance MySQL database connection
	 * 
	 * @throws Exception on DB context query failure
	 */
	private function initialize () {
		$this->connection = new \mysqli (
			$this->host.':'.$this->port,
			$this->user,
			$this->password
		);
		
		if ($this->connection->query ('use `server`') === false)
			throw new \Exception ('SOMETHING WRONG WITH DB');
	}
}

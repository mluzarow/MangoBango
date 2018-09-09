<?php
namespace Common\MangaInventory\Read;

/**
 * Manga inventory setup service responsible for requesting manga information
 * from the database.
 */
class Service {
	/**
	 * @var Provider read provider
	 */
	private $provider;
	
	/**
	 * Constructor for read service.
	 * 
	 * @param Provider $provider read provider
	 * 
	 * @throws TypeError on invalid argument types
	 */
	public function __construct (Provider $provider) {
		$this->provider = $provider;
	}
}

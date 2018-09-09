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
	
	public function getSeriesCoverData (string $base_dir) : array {
		$path_data = $this->provider->fetchSeriesCovers ();
		$meta_data = $this->provider->fetchMeta ();
		
		$series_data = [];
		foreach ($path_data as $id => $item) {
			$path = '';
			
			if (!empty ($item['ext']))
				$path = "{$base_dir}\\{$item['path']}\\series_cover.{$item['ext']}";
			
			$series_data[] = [
				'id' => $id,
				'link' => "/displaySeries?s={$id}",
				'path' => $path,
				'title' => $meta_data[$id]['name']
			];
		}
		
		uasort ($series_data, function ($a, $b) {
			if ($a['title'] === $b['title']) {
				return $a['id'] > $b['id'] ? -1 : 1;
			}
			
			return $a['title'] > $b['title'] ? -1 : 1;
		});
		
		return $series_data;
	}
}

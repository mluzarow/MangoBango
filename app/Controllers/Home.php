<?php
namespace Controllers;

class Home {
	public function __construct () {
		$db = \Core\Database::getInstance ();
		
		// Get number of series
		$q = '
			SELECT
				(SELECT COUNT(*) FROM `manga_directories_series`) AS `series`,
				(SELECT COUNT(*) FROM `manga_directories_volumes`) AS `volumes`,
				(SELECT COUNT(*) FROM `manga_directories_chapters`) AS `chapters`';
		$r = $db->query ($q);
		
		$view_parameters['box_contents'] = [
			[
				'title' => 'Number of series',
				'value' => $r[0]['series']
			],
			[
				'title' => 'Number of volumes',
				'value' => $r[0]['volumes']
			],
			[
				'title' => 'Number of chapters',
				'value' => $r[0]['chapters']
			]
		];
		
		$view = new \ViewItems\PageViews\HomeView ($view_parameters);
		$view->render ();
	}
}

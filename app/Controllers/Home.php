<?php
namespace Controllers;

class Home {
	public function __construct () {
		$view_parameters = [];
		$view_parameters['box_contents'] = [];
		// Get number of series
		$q = '
			SELECT COUNT(*) AS `count`
			FROM `manga_directories_series`';
		$r = \Core\Database::query ($q);
		
		$view_parameters['box_contents'][] = [
			'title' => 'Number of series',
			'value' => $r[0]['count']
		];
		
		// Get number of volumes
		$q = '
			SELECT COUNT(*) AS `count`
			FROM `manga_directories_volumes`';
		$r = \Core\Database::query ($q);
		
		$view_parameters['box_contents'][] = [
			'title' => 'Number of volumes',
			'value' => $r[0]['count']
		];
		
		// Get number of chapters
		$q = '
			SELECT COUNT(*) AS `count`
			FROM `manga_directories_chapters`';
		$r = \Core\Database::query ($q);
		
		$view_parameters['box_contents'][] = [
			'title' => 'Number of chapters',
			'value' => $r[0]['count']
		];
		
		$view = new \ViewItems\PageViews\HomeView ($view_parameters);
		$view->render ();
	}
}

<?php
declare (strict_types = 1);

namespace Controllers;

class Home {
	/**
	 * Runs page process.
	 */
	public function begin () {
		$db = \Core\Database::getInstance ();
		
		// Get number of series
		$q = '
			SELECT
				(SELECT COUNT(*) FROM `metadata_series`) AS `series`,
				(SELECT COUNT(*) FROM `metadata_volumes`) AS `volumes`,
				(SELECT COUNT(*) FROM `metadata_chapters`) AS `chapters`';
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
		
		return (new \Services\View\Controller ())->
			buildViewService ($_SERVER['DOCUMENT_ROOT'])->
			buildView (
				[
					'name' => 'Home',
					'CSS' => ['Home'],
					'HTML' => 'Home',
					'JS' => []
				],
				$view_parameters
			);
	}
}

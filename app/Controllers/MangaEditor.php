<?php
declare (strict_types = 1);

namespace Controllers;

/**
* Controller for the manga editor.
*/
class MangaEditor {
	/**
	 * Runs page process.
	 */
	public function begin () {
		$service =
			(new \Services\MangaEditor\Package)->
			startService (
				\Core\Database::getInstance (),
				'MangaMetadata'
			);
		
		$service->buildEditor ()->;
		$a = new \ViewItems\Common\Data\Block('Hello');
	}
}

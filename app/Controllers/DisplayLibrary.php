<?php
namespace Controllers;

class DisplayLibrary {
	public function __construct () {
		$test_covers = [
			'http://69.47.79.25:6969/resources/img/test_spine_01.jpg',
			'http://69.47.79.25:6969/resources/img/test_spine_02.jpg',
			'http://69.47.79.25:6969/resources/img/test_spine_03.jpg',
			'http://69.47.79.25:6969/resources/img/test_spine_04.jpg',
			'http://69.47.79.25:6969/resources/img/test_spine_05.jpg',
			'http://69.47.79.25:6969/resources/img/test_spine_06.jpg',
			'http://69.47.79.25:6969/resources/img/test_spine_07.jpg'
		];
		
		echo '<!--';
		foreach ($test_covers as $cover) {
			echo '--><div class="book_spine" style="display:inline-block;">
					<img src="'.$cover.'" />
				</div><!--';
		}
		echo '-->';
	}
}

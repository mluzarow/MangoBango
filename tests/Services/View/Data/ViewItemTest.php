<?php
namespace Tests\Services\View\Data;

use PHPUnit\Framework\TestCase;
use Services\View\Data\ViewItem;

/**
 * Test targetting the general view object.
 */
class ViewItemTest extends TestCase {
	/**
	 * Set up unit test variables.
	 */
	public function setUp () {
		$this->css_tags = [
			'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/UIFrame.css">',
			'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/DisplayLibrary.css">'
		];
		
		$this->html = '
		<div class="library_display_container">
			<div class="manga_series_wrap">
				<h2 class="title">090 Eko to Issho</h2>
				<a href="/displaySeries?s=1">
					<img src="" />
				</a>
			</div>
		</div>';
		
		$this->js_tags = [
			'<script type="text/javascript" src="/External/Javascript/jquery-3.3.1.js"></script>',
			'<script type="text/javascript" src="/ViewItems/JS/dropdown.js"></script>',
			'<script type="text/javascript" src="/ViewItems/JS/logout.js"></script>',
			'<script type="text/javascript" src="/ViewItems/JS/LazyLoader.js"></script>',
			'<script type="text/javascript" src="/ViewItems/JS/LazyLoaderEvents.js"></script>',
			'<script type="text/javascript" src="/ViewItems/JS/DisplayLibrary.js"></script>'
		];
	}
	
	/**
	 * Instances the ViewItem class with the current parameters.
	 * 
	 * @return ViewItem instance of ViewItem
	 */
	public function instance () {
		return new ViewItem (
			$this->css_tags,
			$this->html,
			$this->js_tags
		);
	}
	
	/**
	 * Testing valid parameters yield valid instance.
	 */
	public function testConstructor () {
		$this->assertInstanceOf (ViewItem::class, $this->instance ());
	}
	
	/**
	 * Testing invalid CSS tags parameter yeilds TypeError.
	 *
	 * @dataProvider Tests\TestDataProviders::nonArrayProvider
	 * @expectedException TypeError
	 * 
	 * @param mixed $invalid non-array type
	 */
	public function testInvalidCSSTagsType ($invalid) {
		$this->css_tags = $invalid;
		$this->instance ();
	}
	
	/**
	 * Testing invalid HTML parameter yeilds TypeError.
	 *
	 * @dataProvider Tests\TestDataProviders::nonStringProvider
	 * @expectedException TypeError
	 * 
	 * @param mixed $invalid non-string type
	 */
	public function testInvalidHTMLType ($invalid) {
		$this->html = $invalid;
		
		try {
			$this->instance ();
		} catch (\Throwable $e) {
			var_dump (get_class($e));
		}
		var_dump ($this->html);
	}
	
	/**
	 * Testing invalid JS tags parameter yeilds TypeError.
	 *
	 * @dataProvider Tests\TestDataProviders::nonArrayProvider
	 * @expectedException TypeError
	 * 
	 * @param mixed $invalid non-array type
	 */
	public function testInvalidJSTagsType ($invalid) {
		$this->js_tags = $invalid;
		$this->instance ();
	}
}

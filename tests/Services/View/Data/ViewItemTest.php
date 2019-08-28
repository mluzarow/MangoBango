<?php
declare (strict_types = 1);

namespace Tests\Services\View\Data;

use Services\View\Data\ViewItem;

/**
 * Test targetting the general view object.
 */
class ViewItemTest extends \PHPUnit\Framework\TestCase {
	/**
	 * Set up unit test variables.
	 */
	public function setUp () : void {
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
	 * Testing valid CSS tags parameter yields no exception.
	 * 
	 * @dataProvider validCSSTagsProvider
	 * 
	 * @param array $valid valid CSS tags
	 */
	public function testValidCSSTags ($valid) {
		$this->css_tags = $valid;
		$this->assertInstanceOf (ViewItem::class, $this->instance ());
	}
	
	/**
	 * Data provider for testValidCSSTags().
	 * 
	 * @return array valid CSS tags data
	 */
	public function validCSSTagsProvider () {
		return [
			// Empty
			[[]],
			// One Item
			[['<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/UIFrame.css">']],
			// Multiple Items
			[[
				'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/UIFrame.css">',
				'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/DisplayLibrary.css">'
			]]
		];
	}
	
	/**
	 * Testing invalid CSS tags parameter yeilds TypeError.
	 * 
	 * @dataProvider Tests\DataProviders::nonArrayProvider
	 * 
	 * @param mixed $invalid non-array type
	 */
	public function testInvalidCSSTagsType ($invalid) {
		$this->expectException('\TypeError');
		
		$this->css_tags = $invalid;
		$this->instance ();
	}
	
	/**
	 * Testing invalid CSS tags items type yields InvalidArgumentException.
	 * 
	 * @dataProvider Tests\DataProviders::nonStringProvider
	 * 
	 * @param mixed $invalid non-string type
	 */
	public function testInvalidCSSTagsItemType ($invalid) {
		$this->expectException('\InvalidArgumentException');
		
		$this->css_tags = [$invalid];
		$this->instance ();
	}
	
	/**
	 * Testing valid HTML parameter yields no exception.
	 * 
	 * @dataProvider validHTMLProvider
	 * 
	 * @param array $valid valid HTML
	 */
	public function testValidHTML ($valid) {
		$this->html = $valid;
		$this->assertInstanceOf (ViewItem::class, $this->instance ());
	}
	
	/**
	 * Data provider for testValidHTML().
	 * 
	 * @return array valid HTML data
	 */
	public function validHTMLProvider () {
		return [
			// Empty
			[''],
			// Single tag
			['<div></div>'],
			// Hefty HTML
			[
				'<div class="library_display_container">
					<div class="manga_series_wrap">
						<h2 class="title">090 Eko to Issho</h2>
						<a href="/displaySeries?s=1">
							<img src="" />
						</a>
					</div>
				</div>'
			]
		];
	}
	
	/**
	 * Testing invalid HTML parameter yeilds TypeError.
	 * 
	 * @dataProvider Tests\DataProviders::nonStringProvider
	 * 
	 * @param mixed $invalid non-string type
	 */
	public function testInvalidHTMLType ($invalid) {
		$this->expectException('\TypeError');
		
		$this->html = $invalid;
		$this->instance ();
	}
	
	/**
	 * Testing valid JS tags parameter yields no exception.
	 * 
	 * @dataProvider validJSTagsProvider
	 * 
	 * @param array $valid valid JS tags
	 */
	public function testValidJSTags ($valid) {
		$this->js_tags = $valid;
		$this->assertInstanceOf (ViewItem::class, $this->instance ());
	}
	
	/**
	 * Data provider for testValidJSTags().
	 * 
	 * @return array valid JS tags data
	 */
	public function validJSTagsProvider () {
		return [
			// Empty
			[[]],
			// One Item
			[['<script type="text/javascript" src="/ViewItems/JS/dropdown.js"></script>']],
			// Multiple Items
			[[
				'<script type="text/javascript" src="/ViewItems/JS/dropdown.js"></script>',
				'<script type="text/javascript" src="/ViewItems/JS/logout.js"></script>'
			]]
		];
	}
	
	/**
	 * Testing invalid JS tags parameter yeilds TypeError.
	 * 
	 * @dataProvider Tests\DataProviders::nonArrayProvider
	 * 
	 * @param mixed $invalid non-array type
	 */
	public function testInvalidJSTagsType ($invalid) {
		$this->expectException('\TypeError');
		
		$this->js_tags = $invalid;
		$this->instance ();
	}
	
	/**
	 * Testing invalid JS tags items type yields InvalidArgumentException.
	 * 
	 * @dataProvider Tests\DataProviders::nonStringProvider
	 * 
	 * @param mixed $invalid non-string type
	 */
	public function testInvalidJSTagsItemType ($invalid) {
		$this->expectException('\InvalidArgumentException');
		
		$this->js_tags = [$invalid];
		$this->instance ();
	}
}

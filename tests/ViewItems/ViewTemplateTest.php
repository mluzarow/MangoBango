<?php
namespace Tests\ViewItems;

use PHPUnit\Framework\TestCase;
use ViewItems\ViewTemplate;

class ViewTemplateTest extends TestCase {
	/**
	 * Testing failed instantiation of view class abstract on invalid parameter
	 * type.
	 * 
	 * @dataProvider nonArrayProvider
	 * @expectedException TypeError
	 * 
	 * @param mixed $invalid invalid parameter type data
	 */
	public function testInvalidViewParametersType ($invalid) {
		new ViewTemplate ($invalid);
	}
	
	public function nonArrayProvider() {
		return [
			[5]
		];
	}
}

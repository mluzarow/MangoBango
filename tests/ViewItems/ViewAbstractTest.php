<?php
namespace Tests\ViewItems;

use PHPUnit\Framework\TestCase;
use ViewItems\ViewAbstract;

class ViewAbstractTest extends TestCase {
	/**
	 * Testing failed instantiation of view class abstract on invalid parameter
	 * type.
	 * 
	 * @dataProvider nonArrayProvider
	 * 
	 * @param mixed $invalid invalid parameter type data
	 */
	public function testInvalidViewParametersType ($invalid) {
		new ViewAbstract ($invalid);
	}
	
	public function nonArrayProvider() {
		return [
			[5]
		];
	}
}

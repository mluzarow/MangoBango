<?php
namespace Tests;

/**
 * Data provider sourcing test data for unit tests.
 */
class TestDataProviders {
	/**
	 * Non-array type provider.
	 * 
	 * @return array non-array type data
	 */
	public static function nonArrayProvider () {
		return 
			self::booleanType () +
			self::floatType () +
			self::integerType () +
			self::stringType () +
			[
				// Null
				[null],
				// Objects
				[new \stdClass ()]
			];
	}
	
	private static function booleanType () {
		return [
			[true],
			[false]
		];
	}
	
	private static function floatType () {
		return [
			[1.0],
			[59.1234],
			[-59.1234],
			[-1.0]
		];
	}
	
	private static function integerType () {
		return [
			[1],
			[12345],
			[0],
			[-1],
			[-12345]
		];
	}
	
	private static function stringType () {
		return [
			['1.0'],
			['59.1234'],
			['-59.1234'],
			['-1.0'],
			['1'],
			['12345'],
			['0'],
			['-1'],
			['-12345'],
			['true'],
			['false'],
			['a string'],
			[' '],
			['']
		];
	}
}

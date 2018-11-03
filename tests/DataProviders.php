<?php
namespace Tests;

/**
 * Data provider sourcing test data for unit tests.
 */
class DataProviders {
	/**
	 * Non-array type provider.
	 * 
	 * @return array non-array type data
	 */
	public static function nonArrayProvider () {
		return array_merge (
			self::booleanType (),
			self::floatType (),
			self::integerType (),
			self::stringType (),
			self::nullType (),
			self::objectType ()
		);
	}
	
	/**
	 * Non-string type provider.
	 * 
	 * @return array non-string type data
	 */
	public static function nonStringProvider () {
		return array_merge (
			self::arrayType (),
			self::booleanType (),
			self::floatType (),
			self::integerType (),
			self::nullType (),
			self::objectType ()
		);
	}
	
	/**
	 * Sources array types for providers.
	 * 
	 * @return array array type data
	 */
	private static function arrayType () {
		return [
			[array ()]
		];
	}
	
	/**
	 * Sources boolean types for providers.
	 * 
	 * @return array boolean type data
	 */
	private static function booleanType () {
		return [
			[true],
			[false]
		];
	}
	
	/**
	 * Sources float types for providers.
	 * 
	 * @return array float type data
	 */
	private static function floatType () {
		return [
			[1.0],
			[59.1234],
			[-59.1234],
			[-1.0]
		];
	}
	
	/**
	 * Sources integer types for providers.
	 * 
	 * @return array integer type data
	 */
	private static function integerType () {
		return [
			[1],
			[12345],
			[0],
			[-1],
			[-12345]
		];
	}
	
	/**
	 * Sources null types for providers.
	 * 
	 * @return array null type data
	 */
	private static function nullType () {
		return [
			[null]
		];
	}
	
	/**
	 * Sources object types for providers.
	 * 
	 * @return array object type data
	 */
	private static function objectType () {
		return [
			[new \stdClass ()]
		];
	}
	
	/**
	 * Sources string types for providers.
	 * 
	 * @return array string type data
	 */
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

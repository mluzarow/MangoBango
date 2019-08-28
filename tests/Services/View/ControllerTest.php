<?php
declare (strict_types = 1);

namespace Tests\Services\View;

use Services\View\Controller;
use Services\View\Service;

/**
 * Test targetting the view service controller.
 */
class ControllerTest extends \PHPUnit\Framework\TestCase {
	/**
	 * Instances the view service Controller class with the current parameters.
	 * 
	 * @return Controller instance of Controller
	 */
	public function instance () {
		return new Controller ();
	}
	
	/**
	 * Testing no parameters yield valid instance.
	 */
	public function testConstructor () {
		$this->assertInstanceOf (Controller::class, $this->instance ());
	}
	
	/**
	 * Testing valid root path paramater on method buildViewService yields
	 * valid Service instance.
	 * 
	 * @dataProvider validRootPathProvider
	 * 
	 * @param string $valid valid root path
	 */
	public function testBuildViewServiceValidRootPath ($valid) {
		$this->assertInstanceOf (
			Service::class,
			$this->instance ()->buildViewService ($valid)
		);
	}
	
	/**
	 * Data provider for testBuildViewServiceValidRootPath().
	 * 
	 * @return array valid root path data
	 */
	public function validRootPathProvider () {
		return [
			['~\\www\\MangoBango\\app\\'],
			['C:\\Users\\Mark\\MangoBango\\app\\'],
			['']
		];
	}
	
	/**
	 * Testing invalid root path type paramater on method buildViewService yields
	 * TypeError.
	 * 
	 * @dataProvider Tests\DataProviders::nonStringProvider
	 * 
	 * @param mixed $invalid non-string type
	 */
	public function testBuildViewServiceInvalidRootPathType ($invalid) {
		$this->expectException('\TypeError');
		
		$this->instance ()->buildViewService ($invalid);
	}
}

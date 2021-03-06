<?php
/**
 * =============================================================================
 * Copyright (c) 2013, Philip Graham
 * All rights reserved.
 *
 * This file is part of O-pal and is licensed by the Copyright holder under the
 * 3-clause BSD License.  The full text of the license can be found in the
 * LICENSE.txt file included in the root directory of this distribution or at
 * the link below.
 * =============================================================================
 *
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
namespace zpt\opal;

use \PHPUnit_Framework_TestCase as TestCase;
use \Mockery as M;

require_once __DIR__ . '/test-common.php';

/**
 * This class tests the CompanionGenerator abstract class.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionGeneratorTest extends TestCase {

	protected function setUp() {
		$target = __DIR__ . '/target';
		if (file_exists($target)) {
			exec("rm -r $target");
		}
		mkdir($target);
	}

	protected function tearDown() {
		M::close();
	}

	public function testGenerator() {
		eval ('class LonelyClass {}');
		$director = M::mock('zpt\opal\CompanionDirector');

		$director
			->shouldReceive('getTemplatePath')
			->andReturn(__DIR__ . '/mock/sample.tmpl.php');
		$director
			->shouldReceive('getCompanionName')
			->andReturn('Sample');
		$director
			->shouldReceive('getValuesFor')
			->andReturn([]);

		$target = new Psr4Dir(__DIR__ . '/target');

		$generator = new CompanionGenerator('companion', $director, $target);
		$generator->generate('LonelyClass');

		$this->assertFileExists(
			__DIR__ . '/target/companion/LonelyClassCompanion.php'
		);
	}
}

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

require __DIR__ . '/test-common.php';

use PHPUnit_Framework_TestCase as TestCase;
use \Mockery as M;

/**
 * This class tests the CompanionLoader class.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionLoaderTest extends TestCase {

	protected function tearDown() {
		M::close();
	}

	public function testBasicLoading() {
		// Ensure that a MockCompanion object is available
		eval("namespace companion;class LonelyClassCompanion {}");

		$target = new Psr4Dir(__DIR__ . '/target');

		$loader = new CompanionLoader('companion', $target);

		$instance = $loader->get('LonelyClass');
		$this->assertInstanceOf('companion\LonelyClassCompanion', $instance);
	}

	public function testNamespacePrefixLoading() {
		// Ensure that a MockCompanion object is available
		eval("namespace dyn\companion;class LonelyClassCompanion {}");

		$target = new Psr4Dir(__DIR__ . '/target', 'dyn');

		$loader = new CompanionLoader('companion', $target);

		$instance = $loader->get('LonelyClass');
		$this->assertInstanceOf('dyn\companion\LonelyClassCompanion', $instance);
	}

	public function testCacheDisabled() {
		// Ensure that a mock companion class is defined
		eval("namespace uncached\companion; class LonelyClassCompanion {}");

		$target = new Psr4Dir(__DIR__ . '/target', 'uncached');
		$loader = new CompanionLoader('companion', $target);

		$instance1 = $loader->get('LonelyClass', false);
		$instance2 = $loader->get('LonelyClass', false);

		$this->assertFalse($instance1 === $instance2);
	}

	public function testCompanionAware() {
		$classDef = <<<'CLASS'
namespace aware\companion;
class LonelyClassCompanion implements \zpt\opal\CompanionAwareInterface {
	private $fSet = false;
	public function setCompanionLoaderFactory(\zpt\opal\CompanionLoaderFactory $f)
	{
		$this->fSet = true;
	}

	public function wasCalled() { return $this->fSet; }
}
CLASS;

		eval($classDef);

		$target = new Psr4Dir(__DIR__ . '/target', 'aware');
		$loader = new CompanionLoader('companion', $target);

		$instance = $loader->get('LonelyClass');

		$this->assertInstanceOf('aware\companion\LonelyClassCompanion', $instance);
		$this->assertTrue($instance->wasCalled());
	}
}

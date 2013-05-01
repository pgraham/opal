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
namespace zpt\opal\test;

require __DIR__ . '/test-common.php';

use PHPUnit_Framework_TestCase as TestCase;
use zpt\opal\CompanionLoader;

/**
 * This class tests the CompanionLoader class.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionLoaderTest extends TestCase {

	protected function setUp() {
		// Ensure that a MockCompanion object is available
		eval("namespace mock;class SimpleCompanion {}");
	}


	public function testBasicLoading() {
		$loader = new CompanionLoader();

		$instance = $loader->get('mock', 'SimpleCompanion');
		$this->assertObjectHasAttribute('opalLoader', $instance);
		$this->assertInstanceOf('zpt\opal\CompanionLoader', $instance->opalLoader);
	}
}

<?php
/*
 * Copyright (c) 2014, Philip Graham
 * All rights reserved.
 *
 * This file is part of O-pal. For the full copyright and license information
 * please view the LICENSE file that was distributed with this source code.
 */
namespace zpt\opal;

use ReflectionClass;

/**
 * Base class for classes that participate in the process of providing
 * a companion class for a class.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
abstract class CompanionProvider
{

	/**
	 * Get and normalize the companion name for a class using the given
	 * {@link CompanionDirector}.
	 *
	 * @param string $className
	 * @param CompanionDirector $director
	 */
	protected function getCompanionName($className, CompanionDirector $director
	) {
		return trim($director->getCompanionName($className), '\\');
	}

	/**
	 * Transform a namespace into a file system path.
	 *
	 * @param string $ns
	 * @return string
	 */
	protected function nsToPath($ns) {
		return str_replace('\\', DIRECTORY_SEPARATOR, $ns);
	}

}

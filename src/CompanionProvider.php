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

	protected $type;

	/**
	 * Initialize the CompanionProvider
	 *
	 * @param string $type
	 *   Alias for the type of companion generated by the instance. This is used
	 *   to generate unique names for different companions of the same companioned
	 *   class.
	 */
	protected function __construct($type) {
		$this->type = $type;
	}

	/**
	 * Generate a name for a companion for the given class.
	 *
	 * @param string $className
	 */
	protected function getCompanionName($className) {
		return
			$this->type . '\\' .
			str_replace('\\', '_', $className) .
			ucfirst($this->type);
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

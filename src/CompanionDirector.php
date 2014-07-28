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
 * Interface for classes that coordinate the generation and loading of companion
 * objects.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
interface CompanionDirector
{

	/**
	 * Getter for the path to the companion template.
	 *
	 * @return string
	 */
	public function getTemplatePath();

	/**
	 * Get the fully qualified class name for the companion of the type defined by
	 * the directory for the given class.
	 *
	 * @param string $className
	 */
	public function getCompanionName($className);

	/**
	 * Get the template substitution values for the given class.
	 *
	 * @param ReflectionClass $defClass
	 * @return array
	 */
	public function getValuesFor(ReflectionClass $defClass);

}

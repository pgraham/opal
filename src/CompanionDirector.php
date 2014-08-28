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
 * objects. Each CompanionDirector implementation controls the generation and
 * loading of companions of a single type. It is up to the implementation
 * whether or not companions can be generated for class or only for classes that
 * meet certain requirements.
 *
 * TODO Add loader cache control method(s)
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
	 * Get the template substitution values for the given class.
	 *
	 * @param ReflectionClass $defClass
	 * @return array
	 * @throws UnexpectedValueException
	 *   If the CompanionDirector is not able to generate/load a companion for the
	 *   specified class for any reason.
	 */
	public function getValuesFor(ReflectionClass $defClass);

}

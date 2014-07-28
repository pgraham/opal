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
 * Companion loader.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionLoader extends CompanionProvider
{

	/* Instance cache */
	private $instances = array();

	private $director;
	private $target;

	/**
	 * Create a new loader for classes that live in the given namespace.
	 *
	 * @param string $baseNamespace
	 */
	public function __construct(CompanionDirector $director, Psr4Dir $target) {
		$this->director = $director;
		$this->target = $target;
	}

	/**
	 * Get the generated class instance for the given lonely class.
	 *
	 * @param string $className
	 *   The class for which a companion, of they type provided by this loader,
	 *   should be provided.
	 */
	public function get($className, $useCache = true) {
		if (!$useCache) {
			return $this->instantiate($className);
		}

		if (!array_key_exists($className, $this->instances)) {
			$instance = $this->instantiate($className);
		  $this->instances[$className] = $instance;
		}
		return $this->instances[$className];
	}

	/* Instantiate a companion for the specified class. */
	private function instantiate($model) {
		$companionName = $this->director->getCompanionName($model);

		$psr4Prefix = $this->target->getPrefix();
		if (!empty($psr4Prefix)) {
			$companionName = $psr4Prefix->join($companionName, '\\');
		}

		// Need to explicitely cast to string to avoid attempting to instantiate
		// another instance of zpt\util\String
		$companionName = (string) $companionName;

		$instance = new $companionName();

		// Assign some properties on the companion for convenience.  All properties
		// are prefixed with __opal__
		$instance->__opal__loader = $this;

		return $instance;
	}
}

<?php
/*
 * Copyright (c) 2014, Philip Graham
 * All rights reserved.
 *
 * This file is part of O-pal. For the full copyright and license information
 * please view the LICENSE file that was distributed with this source code.
 */
namespace zpt\opal;

/**
 * Generated class loader.  Each instance of this class loads the set of classes
 * that can be generated from a single class template.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionLoader {

	/* Instance cache */
	private $instances = array();

	/* Naming strategy for instantiating instances. */
	private $namingStrategy;

	/**
	 * Create a new loader for classes that live in the given namespace.
	 *
	 * @param string $baseNamespace
	 */
	public function __construct(NamingStrategy $namingStrategy = null) {
		$this->namingStrategy = $namingStrategy;
	}

	/**
	 * Get the generated class instance for the given target class.
	 *
	 * @param string $targetClass
	 */
	public function get($companionType, $model, $useCache = true) {
		if (is_object($model)) {
			$model = get_class($model);
		}

		if (!$useCache) {
			return $this->instantiate($companionType, $model);
		}

		if (!array_key_exists($companionType, $this->instances)) {
			$this->instances[$companionType] = array();
		}

		$companions =& $this->instances[$companionType];
		if (!array_key_exists($model, $companions)) {
			$instance = $this->instantiate($companionType, $model);
		  $companions[$model] = $instance;
		}
		return $companions[$model];
	}

	/*
	 * =========================================================================
	 * Dependency setters.
	 * =========================================================================
	 */

	/**
	 * Set the naming strategy to use when retrieving aspects.
	 *
	 * @param NamingStrategy $naminStrategy
	 */
	public function setNamingStrategy(NamingStrategy $namingStrategy) {
		$this->namingStrategy = $namingStrategy;
	}

	/*
	 * =========================================================================
	 * Private helpers.
	 * =========================================================================
	 */

	/*
	 * Ensure that a naming strategy is available.  If none has been specified
	 * then a default strategy is used.
	 */
	private function ensureNamingStrategy() {
		if ($this->namingStrategy === null) {
			$this->namingStrategy = new DefaultNamingStrategy();
		}
	}

	/* Instantiate an aspect for the specified class. */
	private function instantiate($companionType, $model) {
		$this->ensureNamingStrategy();
		$className = $this->namingStrategy->getCompanionClassName($model);
		$fq = $companionType . '\\' . $className;

		$instance = new $fq();

		// Assign some properties on the companion for convenience.  All properties
		// are prefixed with __opal__
		$instance->__opal__loader = $this;

		return $instance;
	}
}

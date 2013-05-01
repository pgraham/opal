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

/**
 * Generated class loader.  Each instance of this class loads the set of classes
 * that can be generated from a single class template.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionLoader {

	/* Instance cache */
	private $instances = array();

	/* Whether or not to use the cache when retrieving aspects. */
	private $useCache = true;

	/* Naming strategy for instantiating instances. */
	private $namingStrategy;

	/**
	 * Create a new loader for classes that live in the given namespace.
	 *
	 * @param string $baseNamespace
	 */
	public function __construct(
			NamingStrategy $namingStrategy = null,
			$useCache = true
	) {
		$this->namingStrategy = $namingStrategy;
		$this->useCache = $useCache;
	}

	/**
	 * Get the generated class instance for the given target class.
	 *
	 * @param string $targetClass
	 */
	public function get($companionType, $model) {
		if (is_object($model)) {
			$model = get_class($model);
		}

		if (!$this->useCache) {
			return $this->instantiate($model);
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
	 * Set whether or not to cache aspects. If set to false, all returned
	 * aspects will be new instances.
	 *
	 * @param boolean $useCache
	 */
	public function setCacheEnabled($useCache) {
		$this->useCache = $useCache;
	}

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
		$className = $this->namingStrategy->getClassName($model);
		$fq = $companionType . '\\' . $className;

		$instance = new $fq();
		$instance->opalLoader = $this;

		return $instance;
	}
}

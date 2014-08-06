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

	private $factory;

	/**
	 * Create a new loader for companions of the type defined by the given
	 * {@link CompanionDirector}. Companion names provided by the director will be
	 * prefixed with the prefix from the given {@link Psr4Dir}. If this loader was
	 * created by a {@link CompanionLoaderFactory}, that factory will be provided
	 * so that it can be injected into {@link CompanionAwareInterface} companions
	 * that are loaded.
	 *
	 * @param CompanionDirector $director
	 *   Object which synchronizes the generation and loading of companions of
	 *   a single type.
	 * @param Psr4Dir $target
	 *   PSR-4 prefixed source directory where generated companions are stored.
	 * @param CompanionLoaderFactory $factory
	 *   The factory object used to create this loader.
	 */
	public function __construct(
		CompanionDirector $director,
		Psr4Dir $target,
		CompanionLoaderFactory $factory = null
	) {
		$this->director = $director;
		$this->target = $target;

		if ($factory === null) {
			$factory = new CompanionLoaderFactory($target);
		}
		$this->factory = $factory;
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

		if ($instance instanceof CompanionAwareInterface) {
			$instance->setCompanionLoaderFactory($this->factory);
		}

		return $instance;
	}
}

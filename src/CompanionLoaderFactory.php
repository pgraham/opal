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
 * This class creates {@link CompanionLoader} instances that load different
 * types of companions from the same PSR-4 prefixed source directory.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionLoaderFactory
{

	private $target;
	private $loaders = [];

	public function __construct(Psr4Dir $target) {
		$this->target = $target;
	}

	public function get(CompanionDirector $director) {
		$loaderType = get_class($director);
		if (isset($this->loaders[$loaderType])) {
			return $this->loaders[$loaderType];
		}
		return $this->create($director);
	}

	/**
	 * Create a companion loader for the given {@link CompanionDirector}.
	 *
	 * @param CompanionDirector $director
	 */
	public function create(CompanionDirector $director) {
		$loaderType = get_class($director);
		$loader = new CompanionLoader($director, $this->target, $this);
		$this->setLoader($loaderType, $loader);
		return $loader;
	}

	public function setLoader($loaderType, $loader) {
		$this->loaders[$loaderType] = $loader;
	}


}

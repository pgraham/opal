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

	public function __construct(Psr4Dir $target) {
		$this->target = $target;
	}

	/**
	 * Create a companion loader for the given {@link CompanionDirector}.
	 *
	 * @param CompanionDirector $director
	 */
	public function create(CompanionDirector $director) {
		return new CompanionLoader($director, $target);
	}

}

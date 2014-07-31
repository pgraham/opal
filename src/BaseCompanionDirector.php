<?php
/*
 * Copyright (c) 2014, Philip Graham
 * All rights reserved.
 *
 * This file is part of Conductor. For the full copyright and license information
 * please view the LICENSE file that was distributed with this source code.
 */
namespace zpt\opal;

/**
 * Base implementation of a {@link CompanionDirector}.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
abstract class BaseCompanionDirector implements CompanionDirector
{

	protected $companionType;

	public function __construct() {
		$this->companionType = $this->getCompanionType();
	}

	/**
	 * Implements a common naming strategy for the global set of companions. The
	 * naming strategy is based on each {@link CompanionDirector} implementation
	 * declaring a type name. This is done using the {@link
	 * BaseCompanionDirector#getCompanionType()} method.
	 *
	 * Note that the returned classname is meant to be loaded with a PSR-4
	 * compliant class loader.
	 *
	 * @param string $className
	 *   Fully qualified name of the class for which a companion will be
	 *   generated.
	 */
	public function getCompanionName($className) {
		$basename = str_replace('\\', '_', $className);

		return $basename . $this->companionType;
	}

	/**
	 * Getter the type name of the companions generated by this {@link
	 * CompanionDirector} implementation. Note that this method is called by the
	 * constructor.
	 *
	 * @return string.
	 */
	protected abstract function getCompanionType();
}

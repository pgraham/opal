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

	/**
	 * Initialize the type name for the companions controlled by this instance.
	 *
	 * @param string $type
	 *   Globally unique name for the type of companion controlled by the
	 *   instance.
	 */
	protected function __construct($type) {
		$this->companionType = $type;
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
		$type = $this->companionType;
		$basename = str_replace('\\', '_', $className);

		return $type . '\\' . $basename . ucfirst($type);
	}
}

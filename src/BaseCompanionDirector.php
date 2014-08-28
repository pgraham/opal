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
 * @deprecated There are no known implementations that use the companionType
 *             variable so this class is pretty useless.
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
}

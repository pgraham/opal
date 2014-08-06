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
 * This interface can be implemented by (generated) companion classes in order
 * to declare a dependency on other companions. When a {@link CompanionLoader}
 * instantiates a companion that implements this interface, it will be injected
 * with a CompanionLoaderFactory. The factory is capable of creating
 * {@link CompanionLoader} objects that will load companions using the same
 * PSR-4 prefixed directory as the CompanionLoader that created the companion
 * aware companion.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
interface CompanionAwareInterface
{

	public function setCompanionLoaderFactory(CompanionLoaderFactory $factory);
}

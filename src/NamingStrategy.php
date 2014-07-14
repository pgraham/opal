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
 * Interface for classes that provide class names for generated classes.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
interface NamingStrategy
{

	/**
	 * Get the basename of any generated class based on the specified target
	 * class. Generated classes based on the same target class but a different
	 * class template will all have the same base name and will be 
	 * differentiated by their namespace.
	 *
	 * @param string $targetClass
	 */
	public function getCompanionClassName($targetClass);
	
}

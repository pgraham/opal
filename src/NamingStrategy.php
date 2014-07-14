<?php
/**
 * =============================================================================
 * Copyright (c) 2013, Philip Graham
 * All rights reserved.
 *
 * This file is part of php-code-templates and is licensed by the Copyright
 * holder under the 3-clause BSD License.  The full text of the license can be
 * found in the LICENSE.txt file included in the root directory of this
 * distribution or at the link below.
 * =============================================================================
 *
 * @license http://www.opensource.org/licenses/bsd-license.php
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

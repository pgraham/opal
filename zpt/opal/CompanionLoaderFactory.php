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
 * This class creates Companion loaders. Each CompanionLoader instance loads one
 * class of companions.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionLoaderFactory {

    private $loaders = array();
    private $namingStrategy;

    public function __construct(NamingStrategy $namingStrategy = null) {
        $this->namingStrategy = $namingStrategy;
    }

    public function getLoader($baseNamespace) {
        if (!array_key_exists($baseNamespace, $this->loaders)) {
            $loader = new CompanionLoader($baseNamespace);
            $loader->setFactory($this);

            if ($this->namingStrategy !== null) {
                $loader->setNamingStrategy($this->namingStrategy);
            }

            $this->loaders[$baseNamespace] = $loader;
        }
        return $this->loaders[$baseNamespace];
    }
}

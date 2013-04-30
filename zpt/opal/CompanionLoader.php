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
 * Generated class loader.  Each instance of this class loads the set of classes
 * that can be generated from a single class template.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionLoader
{

    /* Instance cache */
    private $instances = array();

    /* Whether or not to use the cache when retrieving aspects. */
    private $useCache = true;

    /* The base namespace for instances created by this loader. */
    private $baseNamespace;

    /* Naming strategy for instantiating instances. */
    private $namingStrategy;

    /* The factory used to create this loader, or a new factory if not set. */
    private $factory;

    /**
     * Create a new loader for classes that live in the given namespace.
     *
     * @param string $baseNamespace
     */
    public function __construct($baseNamespace)
    {
        $this->baseNamespace = $baseNamespace;
    }

    /**
     * Get the generated class instance for the given target class.
     *
     * @param string $targetClass
     */
    public function get($targetClass)
    {
        if (is_object($targetClass)) {
            $targetClass = get_class($targetClass);
        }

        if (!$this->useCache) {
            return $this->instantiate($targetClass);
        }

        if (!array_key_exists($targetClass, $this->instances)) {
            $instance = $this->instantiate($targetClass);
            $instance->opalLoader = $this;
            $this->instances[$targetClass] = $instance;
        }
        return $this->instances[$targetClass];
    }

    /**
     * Getter for a CompanionLoaderFactory instances.  If this loader was
     * instantiated by a factory then it will be the factory returned by this
     * method.
     *
     * @return CompanionLoaderFactory
     */
    public function getFactory() {
        $this->ensureFactory();
        return $this->factory;
    }

    /*
     * =========================================================================
     * Dependency setters.
     * =========================================================================
     */

    /**
     * Set whether or not to cache aspects. If set to false, all returned
     * aspects will be new instances.
     *
     * @param boolean $useCache
     */
    public function setCacheEnabled($useCache)
    {
        $this->useCache = $useCache;
    }

    /**
     * Setter for the factory used to create this loader. This method should 
     * typically only be invoked by CompanionLoaderFactory instances.
     *
     * @param CompanionLoaderFactory $factory
     */
    public function setFactory(CompanionLoaderFactory $factory) {
        $this->factory = $factory;
    }

    /**
     * Set the naming strategy to use when retrieving aspects.
     *
     * @param NamingStrategy $naminStrategy
     */
    public function setNamingStrategy(NamingStrategy $namingStrategy)
    {
        $this->namingStrategy = $namingStrategy;
    }

    /*
     * =========================================================================
     * Private helpers.
     * =========================================================================
     */

    /*
     * Ensuer that a CompanionLoaderFactory is available. If none has been 
     * specified then a new factory is instantiated.
     */
    private function ensureFactory() {
        if ($this->factory === null) {
            $this->factory = new CompanionLoaderFactory();
        }
    }

    /*
     * Ensure that a naming strategy is available.  If none has been specified 
     * then a default strategy is used.
     */
    private function ensureNamingStrategy() {
        if ($this->namingStrategy === null) {
            $this->namingStrategy = new DefaultNamingStrategy();
        }
    }

    /* Instantiate an aspect for the specified class. */
    private function instantiate($targetClass)
    {
        $this->ensureNamingStrategy();
        $className = $this->namingStrategy->getClassName($targetClass);
        $fq = $this->baseNamespace . "\\$className";
        $instance = new $fq();

        return $instance;
    }
}

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
 * Default naming strategy for generated classes.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class DefaultNamingStrategy implements NamingStrategy
{

    public function getCompanionClassName($targetClass)
    {
        return str_replace('\\', '_', $targetClass);
    }
}

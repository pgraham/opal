<?php
/*
 * Copyright (c) 2014, Philip Graham
 * All rights reserved.
 *
 * This file is part of O-pal. For the full copyright and license information
 * please view the LICENSE file that was distributed with this source code.
 */
namespace zpt\opal;

use Composer\Autoload\ClassLoader;

/**
 * This class encapsulates a PSR-4 mapping from a directory to a namespace
 * prefix.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class Psr4Dir
{

	private $path;
	private $prefix;

	public function __construct($path, $prefix = '') {
		$this->path = String(rtrim($path, '/'));
		$this->prefix = String($prefix);
	}

	public function getPath() {
		return $this->path;
	}

	public function getPrefix() {
		return $this->prefix;
	}

	public function registerWith(ClassLoader $loader) {
		$loader->addPsr4((string) $this->prefix, (string) $this->path);
	}
}

<?php
/*
 * Copyright (c) 2014, Philip Graham
 * All rights reserved.
 *
 * This file is part of O-pal. For the full copyright and license information
 * please view the LICENSE file that was distributed with this source code.
 */
namespace zpt\opal;

use zpt\pct\CodeTemplateParser;
use ReflectionClass;
use SplFileObject;


/**
 * This class provides functionality for generating a companion object for a
 * class using a template.
 *
 * @author Philip Graham <philip@zeptech.ca>
 */
class CompanionGenerator extends CompanionProvider
{

	private $director;
	private $target;

	private $template;

	/**
	 * Create a new generator that outputs to the given path.  The given output
	 * path is used as a base path.
	 *
	 * @param string $outputPath The target path for the generated companion.
	 * @param CompanionDirector $director
	 *   Object which specifies the template to use for the companion as well as
	 *   how to name the generated companion
	 */
	public function __construct(CompanionDirector $director, Psr4Dir $target)
	{
		$this->target = $target;
		$this->director = $director;

		$parser = new CodeTemplateParser();
		$this->template = $parser->parse($director->getTemplatePath());
	}

	/**
	 * Generate a companion for the given class.
	 *
	 * @param string|object|ReflectionClass $defClass
	 *   Either the name of a class, an instance of a class or a ReflectionClass
	 *   instance.
	 */
	public function generate($defClass) {
		list($className, $refClass) = $this->getClassInfo($defClass);

		$companionName = $this->getCompanionName($className, $this->director);

		$companionNameParts = explode('\\', $companionName);
		$companionClass = array_pop($companionNameParts);
		$companionNs = implode('\\', $companionNameParts);

		$companionNsPath = $this->nsToPath($companionNs);
		$outDir = $this->target->getPath()->pathJoin($companionNsPath);
		$outPath = $outDir->pathJoin($companionClass . '.php');

		$psr4Prefix = $this->target->getPrefix();
		if (!empty($psr4Prefix)) {
			$companionNs = $psr4Prefix->join($companionNs, '\\');
		}
		$values = $this->director->getValuesFor($refClass);
		$values['companionNs'] = $companionNs;
		$values['companionClass'] = $companionClass;
		$values['model'] = $className;
		$values['modelStr'] = str_replace('\\', '\\\\', $className);

		$resolved = $this->template->forValues($values);

		if (!file_exists($outDir)) {
			mkdir($outDir, 0755, true);
		}

		$file = new SplFileObject($outPath, 'w');
		$file->fwrite($resolved);
	}

	/*
	 * Transform the given class definition into a class name and
	 * a ReflectionClass instance.
	 */
	private function getClassInfo($defClass) {
		if (is_object($defClass)) {
			if ($defClass instanceof ReflectionClass) {
				$className = $defClass->getName();
				$refClass = $defClass;
			} else {
				$className = get_class($defClass);
				$refClass = new ReflectionClass($className);
			}
		} else {
			$className = $defClass;
			$refClass = new ReflectionClass($className);
		}

		return [ $className, $refClass ];
	}
}

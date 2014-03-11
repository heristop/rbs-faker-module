<?php

/**
 * This file is part of the Faker module.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Heri\Faker\Guessers;

use \Change\Documents\Property;

class ColumnType
{
	protected $generator;

	public function __construct(\Faker\Generator $generator)
	{
		$this->generator = $generator;
	}
	
	public function guessFormat(\Change\Documents\Property $property)
	{
		$generator = $this->generator;
		$name = $property->getName();
		
		$type = $property->getType();
		switch ($type)
		{
			case Property::TYPE_BOOLEAN:
				return function() use ($generator) { return $generator->boolean; };
			case Property::TYPE_INTEGER:
				return function() { return mt_rand(0,32767); };
			case Property::TYPE_FLOAT:
			case Property::TYPE_DECIMAL:
				return function() { return mt_rand(0,intval('4294967295'))/mt_rand(1,intval('4294967295')); };
			case Property::TYPE_STRING:
				return function() use ($generator) { return $generator->text(20); };
			case Property::TYPE_RICHTEXT:
			case Property::TYPE_LONGSTRING:
				return function() use ($generator) { return $generator->text; };
			case Property::TYPE_DATETIME:
				return function() use ($generator) { return $generator->dateTimeThisYear; };
			case Property::TYPE_DATE:
				return function() use ($generator) { return $generator->date('Y-m-d'); };
			default:
				// no smart way to guess what the user expects here
				return null;
		}
	}

}
<?php

/**
 * This file is part of the Faker module.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Heri\Faker\Configuration;

use Faker\Generator;
use Zend\Json\Json;

class FormatterFactory
{
	public static function createClosure($generator, array $options = array())
	{
		$method = self::findMethod($options)->get();
		$parameters = self::findParameters($options)->getOrElse(array());
		
		if (is_null($method))
		{
			return null;
		}
		
		if (0 === count($parameters))
		{
			return function() use ($generator, $method) { return $generator->$method(); };
		}

		return function() use ($generator, $method, $parameters)
		{
			return call_user_func_array(array($generator, $method), (array) $parameters);
		};
	}
	
	public function findEntities(\Change\Configuration\Configuration $configuration)
	{
		// load default configuration
		$defaultConfig = self::findDefaultConfig()->getOrElse(array());
		
		// load custom configuration
		$customConfig = self::findCustomConfig($configuration)->getOrThrow(
			new \RuntimeException("Configure entities to populate in 'project.json'")
		);
		
		return \PhpOption\Option::fromValue(array_replace_recursive($defaultConfig, $customConfig));
	}
	
	public static function findSectionByLCID(\Change\Configuration\Configuration $configuration, $LCID)
	{
		return \PhpOption\Option::fromValue($configuration->getEntry('Heri/Faker/section'));
	}
	
	protected static function findDefaultConfig()
	{
		$configPath = __DIR__ . '/../Configuration/Assets/config.json';
		
		if (is_file($configPath))
		{
			return new \PhpOption\Some(Json::decode(
				file_get_contents($configPath),
				Json::TYPE_ARRAY
			));
		}
		
		return \PhpOption\None::create();
	}
	
	protected static function findCustomConfig(\Change\Configuration\Configuration $configuration)
	{
		return \PhpOption\Option::fromValue($configuration->getEntry('Heri/Faker/entities'));
	}
	
	protected static function findMethod($options)
	{
		if (isset($options['method']))
		{
			return new \PhpOption\Some($options['method']);
		}
		
		return \PhpOption\None::create();
	}
	
	protected static function findParameters($options)
	{
		if (isset($options['parameters']))
		{
			return new \PhpOption\Some($options['parameters']);
		}
		
		return \PhpOption\None::create();
	}
}
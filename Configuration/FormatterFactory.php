<?php
namespace Heri\Faker\Configuration;

use Faker\Generator;

class FormatterFactory
{
	public static function createClosure($generator, $method, array $parameters = array())
	{
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
}
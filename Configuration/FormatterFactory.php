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
	
	public static function merge($array1, $array2)
	{
		foreach ($array2 as $key => $value)
		{
			if (array_key_exists($key, $array1) && is_array($value))
			{
				$array1[$key] = self::merge($array1[$key], $array2[$key]);
			}
			else
			{
				$array1[$key] = $value;
			}
		}

		return $array1;
	  
	}
}
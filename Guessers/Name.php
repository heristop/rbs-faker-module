<?php

/**
 * This file is part of the Faker module.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Heri\Faker\Guessers;

use \Faker\Provider\Base;

class Name
{
	protected $generator;

	public function __construct(\Faker\Generator $generator)
	{
		$this->generator = $generator;
	}

	public function guessFormat(\Change\Documents\Property $property)
	{
		$name = Base::toLower($property->getName());
		$generator = $this->generator;
		if (preg_match('/(_a|A)t$/', $name))
		{
			return function() use ($generator) { return $generator->dateTime; };
		}
		if (preg_match('/url/', $name))
		{
			return function() use ($generator) { return $generator->url; };
		}
		
		switch ($name) {
			case 'title':
			case 'label':
				return function() use ($generator) { return $generator->label; };
			case 'code':
				return function() use ($generator) { return $generator->code; };
			case 'active':
				return function() use ($generator) { return $generator->boolean; };
			case 'description':
				return function() use ($generator) { return $generator->realText; };
			case 'ean13':
				return function() use($generator) { return $generator->barcode(13); };
			case 'upc':
				return function() use($generator) { return $generator->optional()->barcode(12); };
			case 'jan':
			case 'isbn':
				return function() use($generator) { return $generator->optional()->barcode(13); };
			case 'publicationstatus':
				return function() use($generator) { return $generator->publicationStatus; };
			case 'first_name':
			case 'firstname':
				return function() use ($generator) { return $generator->firstName; };
			case 'last_name':
			case 'lastname':
				return function() use ($generator) { return $generator->lastName; };
			case 'username':
			case 'authorname':
			case 'login':
				return function() use ($generator) { return $generator->userName; };
			case 'email':
				return function() use ($generator) { return $generator->email; };
			case 'phone_number':
			case 'phonenumber':
			case 'phone':
				return function() use ($generator) { return $generator->phoneNumber; };
			case 'address':
				return function() use ($generator) { return $generator->address; };
			case 'city':
				return function() use ($generator) { return $generator->city; };
			case 'streetaddress':
				return function() use ($generator) { return $generator->streetAddress; };
			case 'postcode':
			case 'zipcode':
				return function() use ($generator) { return $generator->postcode; };
			case 'state':
				return function() use ($generator) { return $generator->state; };
			case 'country':
				return function() use ($generator) { return $generator->country; };
			case 'body':
			case 'summary':
				return function() use ($generator) { return $generator->text; };
		}
	}
}
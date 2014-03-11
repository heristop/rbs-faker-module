<?php

/**
 * This file is part of the Faker module.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Heri\Faker\Tests\Configuration;

use Heri\Faker\Configuration\FormatterFactory;
use ChangeTests\Change\TestAssets\TestCase;

class ProductTest extends TestCase
{
	public function testBarcode()
	{
		$generator = new \Faker\Generator();
		$provider = new \Heri\Faker\Providers\Product($generator);
		$generator->addProvider($provider);

		$closure = FormatterFactory::createClosure($generator, array(
			'method' => 'barcode',
			'parameters' => array('length' => 13)
		));

		$this->assertTrue(is_callable($closure));
		$ean13 = $closure();

		$this->assertRegExp('/[0-9]{13}/', $ean13);
		
		$closure = FormatterFactory::createClosure($generator, array(
			'method' => 'barcode',
			'parameters' => array('length' => 8)
		));

		$this->assertTrue(is_callable($closure));
		$ean8 = $closure();

		$this->assertRegExp('/[0-9]{8}/', $ean8);
	}
	
	public function testStoreImage()
	{
		$generator = new \Faker\Generator();
		$provider = new \Heri\Faker\Providers\Product($generator);
		$provider->setStorageManager($this->getApplicationServices()->getStorageManager());
		$generator->addProvider($provider);
		$provider = new \Faker\Provider\Image($generator);
		$generator->addProvider($provider);

		$closure = FormatterFactory::createClosure($generator, array(
			'method' => 'storeImage',
			'parameters' => array(
				'width' => 640,
				'height' => 480
			)
		));

		$this->assertTrue(is_callable($closure));
		//$path = $closure();

		//$this->assertTrue(is_string($path));
		//$this->assertRegExp('/^change:\/\//', $path);
	}
}
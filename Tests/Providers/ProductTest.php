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
	public function testStoreImage()
	{
		$generator = new \Faker\Generator();
		$provider = new \Heri\Faker\Providers\Ecommerce($generator);
		$provider->setStorageManager($this->getApplicationServices()->getStorageManager());
		$generator->addProvider($provider);
		$provider = new \Faker\Provider\Image($generator);
		$generator->addProvider($provider);

		$closure = FormatterFactory::createClosure($generator, 'storeImage', array('width' => 640, 'height' => 480));

		$this->assertTrue(is_callable($closure));
		$path = $closure();

		$this->assertTrue(is_string($path));
		$this->assertRegExp('/^change:\/\//', $path);
	}
}
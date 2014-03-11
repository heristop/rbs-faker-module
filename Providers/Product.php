<?php

/**
 * This file is part of the Faker module.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Heri\Faker\Providers;

use Change\Storage\StorageManager;
use Change\Documents\Interfaces\Publishable;

class Product extends \Faker\Provider\Base
{
	protected $storageManager;
	
	public function label($nbWords = 3)
	{
		$sentence = $this->generator->sentence($nbWords);
		return substr($sentence, 0, strlen($sentence) - 1);
	}
	
	/**
	 * @example VOLUPTATEM-AUTEM-REPREHENDERIT
	 */
	public function code()
	{
		return strtoupper(implode('-', $this->generator->words(3)));
	}
	
	/**
	 * @example 7674804128761
	 */
	public function barcode($length)
	{
		$values = array();
		for ($i = 0; $i < $length; $i++)
		{
			$values[] = $this->generator->randomDigit;
		}
		
		return implode('', $values);
	}
	
	/**
	 * @example 'Samsung'
	 */
	public static function manufacturer()
	{
		return static::randomElement(static::$manufacturer);
	}
	
	/**
	 * @example 'White Tablet'
	 */
	public function product()
	{
		$format = static::randomElement(static::$productFormats);
		
		return $this->generator->parse($format);
	}
	
	/**
	 * @example 'Tablet'
	 */
	public static function category()
	{
		return static::randomElement(static::$category);
	}
	
	public function publicationStatus()
	{
		return Publishable::STATUS_DRAFT;
	}
	
	/**
	* Image generation provided by LoremPixel (http://lorempixel.com/)
	*
	* @param $width/$height Size (in pixel) of the generated image (defaults to 640x480)
	* @param $category One of 'abstract','animals','business','cats','city','food','nightlife',
	* 'fashion','people','nature','sports','technics', and 'transport'
	*/
	public function storeImage($width = 320, $height = 240, $category = null)
	{
		$this->storageManager->addStorageConfiguration('images', array(
			'class' => "\\Change\\Storage\\Engines\\LocalImageStorage"
		));
		
		$storageURI = 'change://images/'.$this->generator->randomNumber(8).'.jpg';
		file_put_contents($storageURI, file_get_contents($this->generator->imageUrl($width, $height, $category)));
		
		return $storageURI;
	}
	
	public function mimeType($mimeType)
	{
		return $mimeType;
	}
	
	public function setStorageManager(StorageManager $storageManager)
	{
		$this->storageManager = $storageManager;
	}
	
}
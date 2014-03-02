<?php
namespace Heri\Faker\Providers;

use Change\Storage\StorageManager;
use Change\Documents\Interfaces\Publishable;

class Document extends \Faker\Provider\Base
{
	protected $storageManager;
	
	public function label($nbWords = 3)
	{
		$sentence = $this->generator->sentence($nbWords);
		return substr($sentence, 0, strlen($sentence) - 1);
	}
	
	public function code()
	{
		return strtoupper(implode('-', $this->generator->words(3)));
	}
	
	public function mimeType($mimeType)
	{
		return $mimeType;
	}
	
	public function publicationStatus()
	{
		return Publishable::STATUS_DRAFT;
	}
	
	/**
	* Image generation provided by LoremPixel (http://lorempixel.com/)
	*
	* @param $width/$height Size (in pixel) of the generated image (defaults to 640x480)
	* @param $category One of 'abstract','animals','business','cats','city','food','nightlife','fashion','people','nature','sports','technics', and 'transport'
	*/
	public function storeImage($width = 640, $height = 480, $category = null)
	{
		$this->storageManager->addStorageConfiguration('images', array(
			'class' => "\\Change\\Storage\\Engines\\LocalImageStorage"
		));
		
		$storageURI = 'change://images/'.$this->generator->randomNumber(8).'.jpg';
		file_put_contents($storageURI, file_get_contents($this->generator->imageUrl($width, $height, $category)));
		
		return $storageURI;
	}
	
	public function setStorageManager(StorageManager $storageManager)
	{
		$this->storageManager = $storageManager;
	}
	
}
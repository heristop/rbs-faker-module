<?php
namespace Heri\Faker\Providers;

use Change\Storage\StorageManager;
use Change\Documents\Interfaces\Publishable;

class Ecommerce extends \Faker\Provider\Base
{
	protected $storageManager;
	
	protected static $manufacturer = array(
		'3COM', '3DX', '3M', 'A-Data', 'A4-Tech', 'Abit', 'ABM', 'Acer', 'Acme', 'Adobe', 'AEG', 'Aerocool',
		'Agama', 'Agfa', 'Ahead', 'AKG', 'Akira', 'AKYGA', 'Alcatel', 'Alcor', 'Amazon', 'AMD', 'AOC',
		'Apacer', 'APC', 'Apollo', 'Apple', 'Archos', 'ARCTIC-COOLING', 'Arnova', 'Aspire', 'AsRock', 'Asus',
		'AutoDesk', 'AverMedia', 'Aviosys', 'Axis', 'Be quiet!', 'BeastVision', 'Belkin', 'Benq', 'Best Buy',
		'BestConnection', 'Biostar', 'Bitfenix', 'Brother', 'C-Media', 'Canon', 'Canyon', 'Case Logic',
		'Chieftec', 'Cisco', 'Codegen', 'COLOROVO', 'Compaq', 'Conceptronic', 'ConCorde', 'CoolerMaster',
		'Coolink', 'Corel', 'Corsair', 'Creative', 'Crucial', 'D-Link', 'Emtec', 'Epson', 'Equip',
		'ESET', 'Evolve', 'Foxconn', 'Fractal Design', 'FSP', 'Fuji', 'Fujifilm', 'Fujitsu', 'G Data',
		'Garmin', 'Geil', 'Gembird', 'Genius', 'Geovision', 'Gigabyte', 'GMC', 'Google', 'GP',
		'Grundig', 'Haier', 'Hama', 'Hanns-G', 'Hitachi', 'HKC', 'Homedics', 'Horizon', 'HP', 'HPQ', 'HTC',
		'Huawei', 'IBM', 'Inno3D', 'Intel', 'iRiver', 'Jabra', 'JBL', 'Kaspersky', 'Kingmax', 'Kingston',
		'Kodak', 'Kolink', 'Konica Minolta', 'Koobe', 'Kraun', 'Kyocera', 'LC Power', 'Legrand', 'Lenovo',
		'LENSPEN', 'LevelOne', 'Lexar', 'Lexmark', 'LG', 'Lian Li', 'Linksys', 'Logilink', 'Logitech',
		'Maxell', 'Memorex', 'Mercury', 'Microsoft', 'Minolta', 'Modecom', 'MSI', 'Navigon', 'NAVON',
		'Netgear', 'NextBook', 'Nikon', 'Nintendo', 'Nokia', 'nVidia', 'OCZ', 'OKI', 'Olympus', 'Orink',
		'Packard Bell', 'Panasonic', 'Pentax', 'Philips', 'Pinnacle', 'Pioneer', 'Prestigio', 'ProColor',
		'QNAP', 'Revoltec', 'Rovio', 'Sagem', 'Sagemcom', 'Saitek', 'Samsonite', 'Samsung', 'Sandisk',
		'Sapphire', 'Seagate', 'Seagate-Maxtor', 'Sennheiser', 'Sharkoon', 'Sharp', 'Siemens', 'Silicon Power',
		'Sony', 'Sygic', 'Symantec', 'Synology', 'Tamron', 'Tangra', 'Targus', 'TDK', 'Tenda',
		'Texas Instruments', 'Thermaltake', 'Thomson', 'TomTom', 'Toshiba', 'TP-Link', 'Transcend', 'Trust',
		'ZTE', 'Zyxel'
	);
	
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
		$result = "";
		for ($i = 0; $i < $length; $i++)
		{
			$result .= mt_rand(0, 9);
		}
	
		return $result;
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
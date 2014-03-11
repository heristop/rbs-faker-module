<?php

/**
 * This file is part of the Faker module.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Heri\Faker\Providers\en_US;

class Hightech extends \Heri\Faker\Providers\Product
{
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
	
	protected static $category = array(
		'Desktop', 'Laptop', 'Notebook', 'Mice', 'Trackball', 'Motherboard', 'Processor',
		'Network device', 'Memory', 'Monitor', 'Printer', 'Scanner', 'Web Camera', 'Tablet',
		'Software', 'Phone', 'PDA', 'Camera', 'MP3 Player', 'PC', 'Mac', 'Flash Drive'
	);
	
	protected static $productFormats = array(
		'{{colorName}} {{category}}'
	);
}
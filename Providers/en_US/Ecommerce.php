<?php
namespace Heri\Faker\Providers\en_US;

class Ecommerce extends \Heri\Faker\Providers\Ecommerce
{
	protected static $category = array(
		'Desktop', 'Laptop', 'Notebook', 'Mice', 'Trackball', 'Motherboard', 'Processor',
		'Network device', 'Memory', 'Monitor', 'Printer', 'Scanner', 'Web Camera', 'Tablet',
		'Software', 'Phone', 'PDA', 'Camera', 'MP3 Player', 'PC', 'Mac', 'Flash Drive'
	);
	
	protected static $productFormats = array(
		'{{colorName}} {{category}}'
	);
}
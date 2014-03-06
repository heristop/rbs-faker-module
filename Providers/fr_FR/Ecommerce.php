<?php
namespace Heri\Faker\Providers\fr_FR;

class Ecommerce extends \Heri\Faker\Providers\Ecommerce
{
	protected static $category = array(
		'Ordinateur', 'Ordinateur portable', 'Souris', 'Trackball', 'Carte mère', 'Processeur', 
		'Réseau', 'Mémoire', 'Scanner', 'Caméra Web', 'Tablette', 
		'Logiciel', 'Téléphone', 'PDA', 'Caméra', 'Lecteur MP3', 'PC', 'Mac', 'Flash Drive'
	);
	
	protected static $productFormats = array(
		'{{category}} {{colorName}}'
	);
}
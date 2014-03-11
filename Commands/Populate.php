<?php

/**
 * This file is part of the Faker module.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Heri\Faker\Commands;

use Change\Commands\Events\Event;
use Heri\Faker\Configuration\FormatterFactory;

/**
 * @name \Heri\Faker\Commands\Populate
 */
class Populate
{
	const DEFAULT_SECTION = "Hightech";
	
	/**
	 * @param Event $event
	 */
	public function execute(Event $event)
	{
		$applicationServices = $event->getApplicationServices();
		$documentManager = $applicationServices->getDocumentManager();
		$transactionManager = $applicationServices->getTransactionManager();
		$storageManager = $applicationServices->getStorageManager();
		$configuration = $event->getApplication()->getConfiguration();
		
		$LCID = $documentManager->getLCID();
		$generator = \Faker\Factory::create($LCID);
		$section = FormatterFactory::findSectionByLCID($configuration, $LCID)->getOrElse(self::DEFAULT_SECTION);
		$class = "\\Heri\\Faker\\Providers\\$LCID\\$section";
		$provider = new $class($generator);
		$provider->setStorageManager($storageManager);
		$generator->addProvider($provider);
		$populator = new \Heri\Faker\Generators\Populator($generator, $documentManager);
		
		// load configuration
		$entities = FormatterFactory::findEntities($configuration)->getOrElse(array());
		
		foreach ($entities as $entity => $config)
		{
			if (!isset($config['number'])) continue;
			
			// manage custom formatters
			$customColumnFormatters = array();
			if (isset($config['custom_formatters']))
			{
				foreach ($config['custom_formatters'] as $property => $options)
				{
					$customColumnFormatters[$property] = FormatterFactory::createClosure(
						$generator,
						$options
					);
				}
			}
			
			$populator->addEntity($entity, $config['number'], $customColumnFormatters);
		}
		$insertedPKs = $populator->execute($transactionManager);
		
		$response = $event->getCommandResponse();
		foreach ($insertedPKs as $class => $pks)
		{
			$response->addInfoMessage(sprintf(
				'Inserted <comment>%s</comment> new document <comment>%s</comment>',
				count($pks),
				$class
			));
		}
		$response->addInfoMessage('Done.');
	}

}
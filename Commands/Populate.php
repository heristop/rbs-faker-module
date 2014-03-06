<?php
namespace Heri\Faker\Commands;

use Change\Commands\Events\Event;
use Faker\Factory;
use Zend\Json\Json;

use Heri\Faker\Configuration\FormatterFactory;

/**
 * @name \Heri\Faker\Commands\Populate
 */
class Populate
{
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
		$class = "\\Heri\\Faker\\Providers\\$LCID\\Ecommerce";
		$provider = new $class($generator);
		$provider->setStorageManager($storageManager);
		$generator->addProvider($provider);
		$populator = new \Heri\Faker\Generators\Populator($generator, $documentManager);
		
		$entities = $configuration->getEntry('Heri/Faker/entities');
		if (empty($entities))
		{
			throw new \Exception("Configure entities to populate in 'project.json'");
		}
		
		// load default module configuration
		$customConfig = function()
		{
			$configPath = __DIR__ . '/../Configuration/Assets/config.json';
			if (is_file($configPath))
			{
				return Json::decode(file_get_contents($configPath), Json::TYPE_ARRAY);
			}
			return array();
		};
		
		$entities = FormatterFactory::merge($entities, $customConfig());
		foreach ($entities as $entity => $config)
		{
			if (!isset($config['number'])) continue;
			
			// manage custom formatters
			$customColumnFormatters = array();
			if (isset($config['custom_formatters']))
			{
				foreach ($config['custom_formatters'] as $property => $param)
				{
					$customColumnFormatters[$property] = FormatterFactory::createClosure(
						$generator,
						$param['method'],
						isset($param['parameters']) ? $param['parameters'] : array()
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
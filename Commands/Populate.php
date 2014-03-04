<?php
namespace Heri\Faker\Commands;

use Change\Commands\Events\Event;
use Faker\Factory;
use Zend\Json\Json;

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
		$LCID = $documentManager->getLCID();
		$transactionManager = $applicationServices->getTransactionManager();
		$storageManager = $applicationServices->getStorageManager();
		$configuration = $event->getApplication()->getConfiguration();
		
		$generator = \Faker\Factory::create($LCID);
		$provider = new \Heri\Faker\Providers\Document($generator);
		$provider->setStorageManager($storageManager);
		$generator->addProvider($provider);
		$populator = new \Heri\Faker\Generators\Populator($generator, $documentManager);
		
		$entities = $configuration->getEntry('Heri/Faker/entities');
		if (empty($entities))
		{
			throw new \Exception('Configure entities to populate in project.json');
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
		
		$entities = array_merge_recursive($customConfig(), $entities);
		if (empty($entities))
		{
			throw new \Exception('Configure entities to populate in project.json');
		}
		
		$customColumnFormatters = array();
		foreach ($entities as $entity => $config)
		{
			// manage custom formatters
			if (isset($config['custom_formatters']))
			{
				foreach ($config['custom_formatters'] as $property => $param)
				{
					$customColumnFormatters[$property] = \Heri\Faker\Configuration\FormatterFactory::createClosure(
						$generator,
						$param['method'],
						isset($param['parameters']) ? $param['parameters'] : array()
					);
				}
			}
			
			$number = isset($config['number']) ? $config['number'] : 0;
			$populator->addEntity($entity, $number, $customColumnFormatters);
		}
		$insertedPKs = $populator->execute($transactionManager);
		
		$response = $event->getCommandResponse();
		foreach ($insertedPKs as $class => $pks) {
			$response->addInfoMessage(sprintf(
				'Inserted <comment>%s</comment> new document <comment>%s</comment>',
				count($pks),
				$class
			));
		}
		$response->addInfoMessage('Done.');
	}

}
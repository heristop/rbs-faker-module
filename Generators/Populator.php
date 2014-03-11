<?php

/**
 * This file is part of the Faker module.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

namespace Heri\Faker\Generators;

use Change\Documents\DocumentManager;
use Change\Transaction\TransactionManager;

/**
 * Service class for populating a database using the Change ORM.
 * A Populator can populate several tables using ActiveRecord classes.
 */
class Populator
{
	protected $generator;
	protected $documentManager;
	protected $entities = array();
	protected $quantities = array();
	protected $generateId = array();

	public function __construct(\Faker\Generator $generator, DocumentManager $documentManager = null)
	{
		$this->generator = $generator;
		$this->documentManager = $documentManager;
	}

	/**
	 * Add an order for the generation of $number records for $entity.
	 *
	 * @param mixed $entity A document classname
	 * @param int   $number The number of entities to populate
	 */
	public function addEntity($entity, $number, $customColumnFormatters = array(), $generateId = false)
	{
		if (!$entity instanceof \Heri\Faker\Generators\EntityPopulator)
		{
			if (null === $this->documentManager)
			{
				throw new \InvalidArgumentException("No document manager passed to Populator.");
			}
			$entity = new \Heri\Faker\Generators\EntityPopulator($entity);
		}
		$entity->setColumnFormatters($entity->guessColumnFormatters($this->documentManager, $this->generator));
		if ($customColumnFormatters)
		{
			$entity->mergeColumnFormattersWith($customColumnFormatters);
		}
		$this->generateId[$entity->getClass()] = $generateId;

		$class = $entity->getClass();
		$this->entities[$class] = $entity;
		$this->quantities[$class] = $number;
	}

	/**
	 * Populate the database using all the Entity classes previously added.
	 *
	 * @param Change\Transaction\TransactionManager $transactionManager
	 *
	 * @return array A list of the inserted PKs
	 */
	public function execute(TransactionManager $transactionManager)
	{
		try
		{
			$transactionManager->begin();
			
			$insertedEntities = array();
			foreach ($this->quantities as $class => $number)
			{
				$generateId = $this->generateId[$class];
				for ($i = 0; $i < $number; $i++)
				{
					$insertedEntities[$class][] = $this->entities[$class]->execute(
						$this->documentManager,
						$insertedEntities,
						$generateId
					);
				}
			}
		}
		catch (\Change\Documents\PropertiesValidationException $e)
		{
			$errors = $e->getPropertiesErrors();
			throw $transactionManager->rollBack($e);
		}
		
		$transactionManager->commit();

		return $insertedEntities;
	}

}
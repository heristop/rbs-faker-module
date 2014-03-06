<?php
namespace Heri\Faker\Generators;

use \Faker\Provider\Base;
use \ColumnMap;

use Change\Documents\Property;
use Change\Documents\DocumentManager;

/**
 * Service class for populating a table through a RbsChange ActiveRecord class.
 */
class EntityPopulator
{
	protected $class;
	protected $columnFormatters = array();

	/**
	 * Class constructor.
	 *
	 * @param string $class Document classname
	 */
	public function __construct($class)
	{
		$this->class = $class;
	}

	public function getClass()
	{
		return $this->class;
	}

	public function setColumnFormatters($columnFormatters)
	{
		$this->columnFormatters = $columnFormatters;
	}

	public function getColumnFormatters()
	{
		return $this->columnFormatters;
	}

	public function mergeColumnFormattersWith($columnFormatters)
	{
		$this->columnFormatters = array_merge($this->columnFormatters, $columnFormatters);
	}

	public function guessColumnFormatters(DocumentManager $documentManager, \Faker\Generator $generator)
	{
		$formatters = array();
		$class = $this->class;
		
		$nameGuesser = new \Heri\Faker\Guessers\Name($generator);
		$columnTypeGuesser = new \Heri\Faker\Guessers\ColumnType($generator);
		
		$document = $documentManager->getNewDocumentInstanceByModelName($this->class);
		foreach ($document->getDocumentModel()->getProperties() as $property)
		{
			// skip properties handled by orm
			if ($this->isDocumentSystemProperty($property))
			{
				continue;
			}
			
			// create random relation
			if (in_array($property->getType(), array(
				Property::TYPE_DOCUMENT,
				Property::TYPE_DOCUMENTID,
				Property::TYPE_DOCUMENTARRAY
			)))
			{
				$relatedDocument = $property->getDocumentType();
				$formatters[$property->getName()] = function($inserted) use ($documentManager, $property, $relatedDocument)
				{
					if (isset($inserted[$relatedDocument]))
					{
						$documentId = $inserted[$relatedDocument][mt_rand(0, count($inserted[$relatedDocument]) - 1)];
						if ($property->getType() == Property::TYPE_DOCUMENTID)
						{
							return $documentId;
						}
						else if ($property->getType() == Property::TYPE_DOCUMENT)
						{
							return $documentManager->getDocumentInstance($documentId);
						}
						else
						{
							// create a collection with only one document
							return new \Change\Documents\DocumentCollection($documentManager, array(
								$documentManager->getDocumentInstance($documentId)
							));
						}
					}
					
					if ($property->getType() == Property::TYPE_DOCUMENTARRAY)
					{
						return array();
					}
					
					return null;
				};
				continue;
			}
			
			if ($formatter = $nameGuesser->guessFormat($property))
			{
				$formatters[$property->getName()] = $formatter;
				continue;
			}
			
			if ($formatter = $columnTypeGuesser->guessFormat($property))
			{
				$formatters[$property->getName()] = $formatter;
				continue;
			}
		}

		return $formatters;
	}

	/**
	 * Insert one new record using the Entity class.
	 */
	public function execute($documentManager, $insertedEntities, $generateId = false)
	{
		$document = $documentManager->getNewDocumentInstanceByModelName($this->class);
		
		foreach ($this->getColumnFormatters() as $column => $format)
		{
			var_dump($column);
			if (null !== $format) {
				$document->getDocumentModel()->setPropertyValue(
					$document,
					$column,
					is_callable($format) ? $format($insertedEntities, $document) : $format
				);
			}
		}
		
		$document->create();
		
		return $document->getId();
	}
	
	protected function isDocumentSystemProperty($property)
	{
		return in_array($property->getName(), array(
			'id',
			'model',
			'creationDate',
			'modificationDate',
			'authorId',
			'authorName',
			'publicationSections',
			'startPublication',
			'endPublication',
			'refLCID',
			'LCID',
			'processingStatus',
			'documentVersion',
			'startActivation',
			'endActivation'
		));
	}

}
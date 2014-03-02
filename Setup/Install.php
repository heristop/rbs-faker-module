<?php
namespace Heri\Faker\Setup;

/**
 * @name \Heri\Faker\Setup\Install
 */
class Install extends \Change\Plugins\InstallBase
{

	/**
	 * @param \Change\Plugins\Plugin $plugin
	 * @param \Change\Application $application
	 * @param \Change\Configuration\EditableConfiguration $configuration
	 * @throws \RuntimeException
	 */
	public function executeApplication($plugin, $application, $configuration)
	{
		$configuration->addPersistentEntry('Change/Events/Commands/Heri_Faker', '\Heri\Faker\Events\Commands\Listeners');
	}
}

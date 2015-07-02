<?php namespace H2akim\Backup\Commands;

use H2akim\Backup\BackupFactory;
use H2akim\Backup\Contracts\BackupEngineInterface;
use H2akim\Backup\Contracts\BackupInterface;
use H2akim\Backup\Contracts\BackupCommandInterface;
use Illuminate\Console\Command;
use Illuminate\Config\Repository as Config;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BackupCommandAbstract extends Command implements BackupCommandInterface {

	/**
	 * Backup factory.
	 *
	 * @var \H2akim\Backup\BackupFactory
	 */
	protected $backupFactory;

	/**
	 * Config instance.
	 *
	 * @var \Illuminate\Config\Repository
	 */
	protected $configInstance;

	/**
	 * Backup instance.
	 *
	 * @var \H2akim\Backup\Contracts\BackupInterface
	 */
	protected $backupInstance;

	/**
	 * Base command constructor.
	 *
	 * @param BackupFactory $backupFactory
	 * @param Config        $configInstance
	 */
	public function __construct(BackupFactory $backupFactory, Config $configInstance)
	{
		parent::__construct();
		$this->backupFactory = $backupFactory;
		$this->configInstance = $configInstance;
	}

	/**
	 * Get a backup instance.
	 *
	 * @param string $database
	 *
	 * @return BackupInterface
	 */
	public function getBackupInstance($database = null)
	{
		$configuration = array_merge($this->getConfig('database'), $this->getConfig('backup::config'));
		$this->backupInstance = $this->backupFactory->build($configuration, $database);

		return $this->backupInstance;
	}

	/**
	 * Fire.
	 *
	 * @return void
	 */
	abstract public function fire();

	/**
	 * Get config by name.
	 *
	 * @param string $name
	 *
	 * @return array|string
	 */
	protected function getConfig($name)
	{
		return $this->configInstance->get($name);
	}
}
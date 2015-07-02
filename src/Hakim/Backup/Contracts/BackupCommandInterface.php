<?php namespace Hakim\Backup\Contracts;

use Hakim\Backup\BackupFactory;
use Hakim\Backup\BackupProcess;
use Illuminate\Config\Repository as Config;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface BackupCommandInterface {

	/**
	 * Base command constructor.
	 *
	 * @param BackupFactory $backupFactory
	 * @param Config        $configInstance
	 */
	public function __construct(BackupFactory $backupFactory, Config $configInstance);

	/**
	 * Get a backup instance.
	 *
	 * @param string $database
	 *
	 * @return BackupInterface
	 */
	public function getBackupInstance($database = null);

	/**
	 * Fire.
	 *
	 * @return void
	 */
	public function fire();

}

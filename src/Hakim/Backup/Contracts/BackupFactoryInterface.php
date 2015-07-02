<?php namespace Hakim\Backup\Contracts;

interface BackupFactoryInterface {

	/**
	 * Build a new Backup object and its dependencies.
	 *
	 * @param array  $options
	 * @param string $database
	 *
	 * @return \Hakim\Backup\Contracts\BackupInterface
	 */
	public function build(
		array $options = [],
		$database = null
	);

	/**
	 * Build the Backup object.
	 *
	 * @param BackupEngineInterface     $backupEngine
	 * @param BackupFilesystemInterface $backupFilesystem
	 * @param array                     $options
	 *
	 * @return \Hakim\Backup\Contracts\BackupInterface
	 */
	public function buildBackup(
		BackupEngineInterface $backupEngine,
		BackupFilesystemInterface $backupFilesystem,
		array $options = []
	);

	/**
	 * Build a new Backup Engine object.
	 *
	 * @param array  $options
	 * @param string $database
	 *
	 * @throws BackupException
	 *
	 * @return \Hakim\Backup\Contracts\BackupEngineInterface
	 */
	public function buildBackupEngine(
		array $options = [],
		$database = null
	);

}

<?php namespace H2akim\Backup;

use H2akim\Backup\Contracts\BackupFactoryInterface;
use H2akim\Backup\Contracts\BackupEngineInterface;
use H2akim\Backup\Backup;
use H2akim\Backup\Contracts\BackupFilesystemInterface;
use H2akim\Backup\Engines\BackupEngineMysql;
use H2akim\Backup\Engines\BackupEnginePgsql;
use H2akim\Backup\Engines\BackupEngineSqlite;
use H2akim\Backup\Engines\BackupEngineSqlsrv;
use H2akim\Backup\Exceptions\BackupException;
use Symfony\Component\Process\Process;

class BackupFactory implements BackupFactoryInterface {

	/**
	 * Build a new Backup object and its dependencies.
	 *
	 * @param array  $options
	 * @param string $database
	 *
	 * @return \H2akim\Backup\Contracts\BackupInterface
	 */
	public function build(
		array $options = [],
		$database = null
	) {
		$backupEngine = $this->buildBackupEngine($options);
		$backupFilesystem = $this->buildBackupFilesystem();

		return $this->buildBackup($backupEngine, $backupFilesystem, $options, $database);
	}

	/**
	 * Build the Backup object.
	 *
	 * @param BackupEngineInterface     $backupEngine
	 * @param BackupFilesystemInterface $backupFilesystem
	 * @param array                     $options
	 *
	 * @return \H2akim\Backup\Contracts\BackupInterface
	 */
	public function buildBackup(
		BackupEngineInterface $backupEngine,
		BackupFilesystemInterface $backupFilesystem,
		array $options = []
	) {
		return new Backup($backupEngine, $backupFilesystem, $options);
	}

	/**
	 * Build a new Backup Engine object.
	 *
	 * @param array  $options
	 * @param string $database
	 *
	 * @throws BackupException
	 *
	 * @return \H2akim\Backup\Contracts\BackupEngineInterface
	 */
	public function buildBackupEngine(
		array $options = [],
		$database = null
	) {
		$backupProcessInstance = new BackupProcess(new Process(''));

		switch ($database ? $database : $options['default'])
		{
			case 'mysql':
				return new BackupEngineMysql(
					$backupProcessInstance,
					$options['connections'][$options['default']]['database'],
					$options['connections'][$options['default']]['host'],
					isset($options['connections'][$options['default']]['port']) ? $options['connections'][$options['default']]['port'] : 3306,
					$options['connections'][$options['default']]['username'],
					$options['connections'][$options['default']]['password'],
					$options
				);
			case 'pgsql':
				return new BackupEnginePgsql(
					$backupProcessInstance,
					$options['connections'][$options['default']]['database'],
					$options['connections'][$options['default']]['host'],
					null,
					$options['connections'][$options['default']]['username'],
					$options['connections'][$options['default']]['password'],
					$options
				);
			case 'sqlite':
				return new BackupEngineSqlite(
					$backupProcessInstance,
					$options['connections'][$options['default']]['database'],
					null,
					null,
					null,
					null,
					$options
				);
			case 'sqlsrv':
				return new BackupEngineSqlsrv(
					$backupProcessInstance,
					$options['connections'][$options['default']]['database'],
					$options['connections'][$options['default']]['host'],
					null,
					$options['connections'][$options['default']]['username'],
					$options['connections'][$options['default']]['password'],
					$options
				);
			default:
				throw new BackupException('Database driver isn\'t supported.');
		}
	}

	/**
	 * Build the Backup filesystem object.
	 *
	 * @return \H2akim\Backup\Contracts\BackupFilesystem
	 */
	public function buildBackupFilesystem() {
		return new BackupFilesystem();
	}

}
  

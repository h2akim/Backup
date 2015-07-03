# An easy way backup and restore databases in Laravel.

Fork from Cornford/Backup
* Add Laravel 4.1 Support

Think of Backup as an easy way to backup and restore a database, with command line integration to Laravel's artisan. These include:

- `Backup::export`
- `Backup::restore`
- `Backup::setBackupEngineInstance`
- `Backup::getBackupEngineInstance`
- `Backup::setBackupFilesystemInstance`
- `Backup::getBackupFilesystemInstance`
- `Backup::setEnabled`
- `Backup::getEnabled`
- `Backup::setPath`
- `Backup::getPath`
- `Backup::setCompress`
- `Backup::getCompress`
- `Backup::setFilename`
- `Backup::getFilename`
- `Backup::getWorkingFilepath`
- `Backup::getRestorationFiles`
- `Backup::getProcessOutput`

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `cornford/backup`.

	"require": {
		"h2akim/backup": "dev-master"
	}

Next, update Composer from the Terminal:

	composer update

Once this operation completes, the next step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

	'H2akim\Backup\Providers\BackupServiceProvider',

The next step is to introduce the facade. Open `app/config/app.php`, and add a new item to the aliases array.

	'Backup'         => 'H2akim\Backup\Facades\Backup',

Finally we need to introduce the configuration files into your application.

	php artisan config:publish h2akim/backup

That's it! You're all set to go.

## Usage

It's really as simple as using the Backup class in any Controller / Model / File you see fit with:

`Backup::`

This will give you access to

- [Export](#export)
- [Restore](#Restore)
- [Set Backup Engine Instance](#set-backup-engine-instance)
- [Get Backup Engine Instance](#get-backup-engine-instance)
- [Set Backup Filesystem Instance](#set-backup-filesystem-instance)
- [Get Backup Filesystem Instance](#get-backup-filesystem-instance)
- [Set Enabled](#set-enabled)
- [Get Enabled](#get-enabled)
- [Set Path](#set-path)
- [Get Path](#get-path)
- [Set Compress](#set-compress)
- [Get Compress](#get-compress)
- [Set Filename](#set-filename)
- [Get Filename](#get-filename)
- [Get Working Filepath](#get-working-filepath)
- [Get Restoration Files](#get-restoration-files)
- [Get Process Output](#get-process-output)

### Export

The `export` method allows a database export file to be created in the defined backup location, with an optional filename option.

	Backup::export();
	Backup::export('database_backup');

### Restore

The `restore` method allows a database export file to be restored to the database, specifying a full filepath to the file.

	Backup::restore('./database_backup.sql');

### Set Backup Engine Instance

The `setBackupEngineInstance` method allows a custom backup engine instance object to be utilised, implementing the BackupEngineInterface.

	Backup::setBackupEngineInstance(new BackupEngineMysql(new BackupProcess(new Symfony\Component\Process\Process), 'database', 'localhost', 3306, 'root', '', []));

### Get Backup Engine Instance

The `getBackupEngineInstance` method returns the current backup engine instance object.

	Backup::getBackupEngineInstance();

### Set Backup Filesystem Instance

The `setBackupFilesystemInstance` method allows a custom backup filesystem instance object to be utilised, implementing the BackupFilesystemInterface.

	Backup::setBackupFilesystemInstance(new BackupFilesystemInstance);

### Get Backup Filesystem Instance

The `getBackupFilesystemInstance` method returns the current backup filesystem instance object.

	Backup::getBackupFilesystemInstance();

### Set Enabled

The `setEnabled` method allows backup to be switched on or off, specifying a boolean for state.

	Backup::setEnabled(true);
	Backup::setEnabled(false);

### Get Enabled

The `getEnabled` method returns the current backup enabled status, returning a boolean for its state.

	Backup::getEnabled();

### Set Path

The `setPath` method allows backup location path to be set, specifying a relative or absolute path as a string, a trailing slash is required.

	Backup::setPath('/path/to/directory/');

### Get Path

The `getPath` method returns the current absolute backup path in string format.

	Backup::getPath();

### Set Compress

The `setCompress` method allows backup file compression to be switched on or off, specifying a boolean for state.

	Backup::setCompress(true);
	Backup::setCompress(false);

### Get Compress

The `getCompress` method returns the current compression backup status, returning a boolean for its state.

	Backup::getCompress();

### Set Filename

The `setFilename` method allows backup filename to be set, specified in a string format.

	Backup::setFilename('database_backup');
	Backup::setFilename('backup-' . date('Ymd-His'));

### Get Filename

The `getFilename` method returns the current set backup filename in a string format.

	Backup::getFilename();

### Get Working Filepath

The `getWorkingFilepath` method returns the current set working filepath of the current item being processed in a string format.

	Backup::getWorkingFilepath();

### Get Restoration Files

The `getRestorationFiles` method returns an array containing all of the restoration file filepaths within a give path, an optional absolute path can be set as a string.

	Backup::getRestorationFiles();
	Backup::getRestorationFiles('/path/to/directory/');

### License

Backup is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

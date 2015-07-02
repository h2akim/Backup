<?php namespace H2akim\Backup\Providers;

use H2akim\Backup\BackupFactory;
use H2akim\Backup\Commands\BackupCommandExport;
use H2akim\Backup\Commands\BackupCommandRestore;
use H2akim\Backup\Exceptions\BackupRestoreException;
use Illuminate\Support\ServiceProvider;

class BackupServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cornford/backup', null, __DIR__ . '/../../../');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['backup'] = $this->app->share(function($app)
			{
				$config = array_merge($app['config']->get('database'), $app['config']->get('backup::config'));

				return (new BackupFactory)->build($config);
			});

		$this->app['db.export'] = $this->app->share(function($app)
			{
				return new BackupCommandExport(new BackupFactory, $app['config']);
			});

		$this->app['db.restore'] = $this->app->share(function($app)
			{
				return new BackupCommandRestore(new BackupFactory, $app['config']);
			});

		$this->commands(
			'db.export',
			'db.restore'
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return string[]
	 */
	public function provides()
	{
		return ['backup'];
	}

}

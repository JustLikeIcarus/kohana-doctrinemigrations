<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The DoctrineMigrations Controller allows the user to run the database
 * migrations, either up or down, using the default database connection.
 *
 * @package    DoctrineMigrations
 * @author     Synapse Studios
 * @copyright  Copyright (c) 2009 Synapse Studios
 */
class Controller_DoctrineMigrations extends Controller {

	/**
	 * Enables Doctrine and establishes a database connection to the default
	 * database as specified in the database config.
	 *
	 * @param   integer  migration version
	 */
	public function before()
	{
		parent::before();
		print Kohana::find_file('vendor', 'doctrine/lib/Doctrine');
		require Kohana::find_file('vendor', 'doctrine/lib/Doctrine');
        spl_autoload_register(array('Doctrine', 'autoload'));
        
		$connection = Doctrine_Manager::connection
    	(
    		Kohana::config('database.default.type').'://'.
    		Kohana::config('database.default.connection.username').':'.
    		Kohana::config('database.default.connection.password').'@'.
    		Kohana::config('database.default.connection.hostname').'/'.
    		Kohana::config('database.default.connection.database')
    	);
	}

	/**
	 * Runs the migration to the specified version or to the latest version if
	 * none is provided.
	 *
	 * @param   integer  migration version
	 */
	public function action_index($version = NULL)
	{
		$migration = new Doctrine_Migration(APPPATH.'migrations');
		$current_version = $migration->getCurrentVersion();
		$latest_version = $migration->getLatestVersion();

		// If the provided version is not an integer then use the latest version
		if ( ! ctype_digit($version))
		{
			$version = $latest_version;
		}

		// If the provided version is higher than the latest version, do nothing
		if ($version > $latest_version)
		{
			echo __('Unable to find migration classes.  No action performed.');
		}
		// If the provided version is equal to the current version, do nothing
		elseif ($version == $current_version)
		{
			echo __('Database is already up to date.  No action necessary');
		}
		// Perform the migration to the provided version
		else
		{
			$migration->migrate($version);
			echo __('Database migration is complete. Database version was
				#'.$current_version.' and now is #'.$version);
		}
	}
}
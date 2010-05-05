<?php defined('SYSPATH') or die('No direct script access.');

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
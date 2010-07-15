<?php defined('SYSPATH') or die('No direct script access.');

require Kohana::find_file('vendor', 'doctrine/lib/Doctrine');
spl_autoload_register(array('Doctrine', 'autoload'));
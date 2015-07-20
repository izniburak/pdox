<?php 
/*
*
* @ Package: PDOx - Useful ORM & PDO Class
*
* @ Author: izni burak demirtas / @izniburak <info@burakdemirtas.org>
* @ Web: http://burakdemirtas.org
* @ URL: https://github.com/izniburak/PDOx
* @ Licence: The MIT License (MIT) - Copyright (c) - http://opensource.org/licenses/MIT
*
*/

require 'vendor/autoload.php';

$config = [
	# Host name or IP Address (not required)
	# default value: localhost
	'host'      => 'localhost',
	
	# Database Driver Type (not required)
	# default value: mysql
	# values: mysql, pgsql, sqlite, oracle
	'driver'    => 'mysql',
	 
	# Database Name (required)
	'database'  => 'test',
	
	# Database User Name (required)
	'username'  => 'root',
	
	# Database User Password (required)
	'password'  => '',
	
	# Database Charset (not required)
	# default value: utf8
	'charset'   => 'utf8',
	
	# Database Charset Collation (not required)
	# default value: utf8_general_ci
	'collation' => 'utf8_general_ci',
	
	# Database Name Prefix (not required)
	# default value:
	'prefix'     => ''
];


// start PDOx
$db = new \buki\PDOx($config);


// Example
$records = $db->from('users')
		->select('id, name, surname, age')
		->where('age', '>', 18)
		->orderBy('id', 'desc')
		->limit(20)
		->getAll();

foreach($records as $record)
{
	echo $record->id . ' - ' . $record->name . ' ' . $record->surname . ' / ' . $record->age . '<br />';
}

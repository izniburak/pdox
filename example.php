<?php 
/*
*
* PHP PDO Database Class for MySQL, PostgreSQL and SQLite
*
* @ Author: izni burak demirtas / @izniburak <info@burakdemirtas.org>
*
* @ Web: http://burakdemirtas.org
*
* @ Docs: http://burakdemirtas.org/pdox-kullanisli-pdo-sinifi-php/
*
* @ Licence: The MIT License (MIT) - Copyright (c) 2014 - http://opensource.org/licenses/MIT
*
*/

	header('content-type: text/html; charset=utf-8');

	// include class
	include('pdox.class.php');

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
	$records = $db->select('id, name, surname, age')
				->from('users')
				->where('age', '>', 18)
				->orderBy('id', 'desc')
				->limit(20)
				->getAll();
	
	foreach($records as $record)
	{
		echo $record->id . ' - ' . $record->name . ' ' . $record->surname . ' / ' . $record->age . '<br />';
	}

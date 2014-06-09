<?php 
/*
*
* PHP PDO Database Class for MySQL, PostgreSQL and SQLite
*
* @ Author: izni burak demirtas / @izniburak <info@burakdemirtas.org>
*
* @ Web: http://burakdemirtas.org
*
* @ Docs: http://burakdemirtas.org/58/pdox-useful-pdo-class-php/
*
* @ Licence: The MIT License (MIT) - Copyright (c) 2014 - http://opensource.org/licenses/MIT
*
*/


	header('content-type: text/html; charset=utf-8');

	
	// include class
	include('pdox.class.php');

	
	// config values
	$config = array(

		/*
		** Database User Name (required)
		*/
		
		'user'		=> 'root',
		
		/*
		** Database User Password (required)
		*/
		
		'pass'		=> '',
		
		/* 
		** Database Name (required)
		*/
		
		'dbname'	=> 'test',
		
		/*
		** Host name or IP Address (not required)
		** default value: localhost
		*/
		
		'host'		=> 'localhost',
		
		/* Database Driver Type (not required)
		** default value: mysql
		** values: mysql, pgsql, sqlite
		*/
		
		'type'		=> 'mysql',
		
		/* Database Charset (not required)
		** default value: utf8
		*/
		
		'charset'	=> 'utf8'
		
	);

	
	// start PDOx
	$db = new PDOx($config);
	
	
	// Example
	
	$records = $db->select('id, name, surname, age')->from('users')->where('age', '>', 18)->orderBy('id', 'desc')->limit(20)->getAll();
	
	foreach($records as $record) {
	
		echo $record->id . ' - ' . $record->name . ' ' . $record->surname . ' / ' . $record->age . '<br />';
	
	}
	
	
	/*
	**
	** FUNCTIONS LIST
	**
	**** select
	**** from
	**** where
	**** orWhere
	**** whereIn
	**** whereNotIn
	**** join
	**** leftJoin
	**** like
	**** orLike
	**** orderBy
	**** groupBy
	**** having
	**** limit
	**** count
	**** insertId
	**** error
	**** get
	**** getAll
	**** insert
	**** update
	**** delete
	**** query
	**** escape
	**
	*/

<?php
/*
*
* @ Package: PDOx - Useful Query Builder & PDO Class
* @ Author: izni burak demirtas / @izniburak <info@burakdemirtas.org>
* @ Web: http://burakdemirtas.org
* @ URL: https://github.com/izniburak/PDOx
* @ Licence: The MIT License (MIT) - Copyright (c) - http://opensource.org/licenses/MIT
*
*/

require 'vendor/autoload.php';

// database config
$config = [
	'host'      => 'localhost',
	'driver'    => 'mysql',
	'database'  => 'test',
	'username'  => 'root',
	'password'  => '',
	'charset'   => 'utf8',
	'collation' => 'utf8_general_ci',
	'prefix'    => ''
];

// start PDOx
$db = new \Buki\Pdox($config);

// Select Records
$records = $db->table('pages')
		->where('age', '>', 18)
		->orderBy('id', 'desc')
		->limit(10)
		->getAll();

var_dump($records);

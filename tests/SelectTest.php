<?php 
	
require 'vendor/autoload.php';

$config = [
    'host'      => 'localhost',
    'driver'    => 'mysql',
    'database'  => 'test',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'     => ''
];

$db = new \Buki\Pdox($config);

$records = $db->table('users')
        ->select('name, surname, age')
        ->where('age', '>', 18)
        ->orderBy('id', 'desc')
        ->limit(20)
        ->getAll();

foreach($records as $record)
{
	echo $record->name . '<br />' . 
		 $record->surname . '<br />' . 
		 $record->age;
}
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


$query = $db->table('pages')->where('year', 2014)->where('status', 0)->delete();

if($query)
{
	echo 'Record(s) deleted!';
}
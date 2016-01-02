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

$data = [
	'username' => 'new-user-name',
	'password' => md5('new-password'),
	'status' => 1
];

$query = $db->table('users')->where('id', 17)->update($data);

if($query)
{
	echo 'Record updated!';
}
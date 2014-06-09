PDOx
====

Useful PHP PDO Class


Example
====
```php

include('pdox.class.php');

$config = array(
	'user'		=> 'root',
	'pass'		=> '',
	'dbname'	=> 'test',
	'host'		=> 'localhost',
	'type'		=> 'mysql',
	'charset'	=> 'utf8'
);


$db = new PDOx($config);


$records = $db->select('id, name, surname, age')->from('users')->where('age', '>', 18)->orderBy('id', 'desc')->limit(20)->getAll();

foreach($records as $record) {

	echo $record->id . ' - ' . $record->name . ' ' . $record->surname . ' / ' . $record->age . '<br />';

}
```

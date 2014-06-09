PDOx
====

Useful PHP PDO Class

[![PayPal ile Destek Ol][paypal-donate-img]][paypal-donate-url]


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

$records = $db->
	select('id, name, surname, age')->
	from('users')->
	where('age', '>', 18)->
	orderBy('id', 'desc')->
	limit(20)->
	getAll();

foreach($records as $record) {

	echo $record->id . ' - ' . $record->name . ' / ' . $record->age . '<br />';

}
```
## Lisans
Açık kaynaklı olan bu proje [MIT lisansı][mit-url] ile lisanslanmıştır.

[paypal-donate-img]: http://img.shields.io/badge/PayPal-donate-brightgreen.svg
[paypal-donate-url]: http://burakdemirtas.org
[mit-url]: http://opensource.org/licenses/MIT

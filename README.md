[![PDOx][pdox-img]][doc-url]

## PDOx
Fast, efficient and useful ORM and PDO Class for #PHP

## Install
```
composer global require "smtaydemir/wpup=dev-master"
```

## Example Usage
```php
require 'vendor/autoload.php';

$config = [
	'host'		=> 'localhost',
	'driver'	=> 'mysql',
	'database'	=> 'test',
	'username'	=> 'root',
	'password'	=> '',
	'charset'	=> 'utf8',
	'collation'	=> 'utf8_general_ci',
	'prefix'	 => ''
];

$db = new \buki\PDOx($config);

$records = $db->select('id, name, surname, age')
		->from('users')
		->where('age', '>', 18)
		->orderBy('id', 'desc')
		->limit(20)
		->getAll();

var_dump($records);
```

## Methods 
```php
select
from
join
leftJoin
rightJoin
where
orWhere
in
notIn
orIn
orNotIn
between
notBetween
orBetween
orNotBetween
like
orLike
orderBy
groupBy
having
limit
count
insertId
error
get
getAll
insert
update
delete
query
escape
```

## Docs 
Documentation page: [PDOx Docs][doc-url] 

Detailed documentation coming soon!

## Licence
[MIT Licence][mit-url]

[pdox-img]: http://burakdemirtas.org/uploads/images/20140610210255_pdox_pdo_class_for_php.jpg
[paypal-donate-url]: http://burakdemirtas.org
[mit-url]: http://opensource.org/licenses/MIT
[doc-url]: http://burakdemirtas.org/pdox-kullanisli-pdo-sinifi-php/

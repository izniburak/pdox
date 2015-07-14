## PDOx
Fast, efficient and useful ORM and PDO Class for #PHP

## Install

composer.json file:
```json
{
    "require": {
        "izniburak/pdox-orm": "dev-master"
    }
}
```
after run the install command.
```
$ composer install
```

OR run the following command directly.

```
$ composer global require "izniburak/pdox-orm=dev-master"
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

## Docs 
Documentation page: [PDOx Docs][doc-url] 

## Support 
[izniburak's homepage][author-url]

[izniburak's twitter][twitter-url]

## Licence
[MIT Licence][mit-url]

[pdox-img]: http://burakdemirtas.org/uploads/images/20140610210255_pdox_pdo_class_for_php.jpg
[paypal-donate-url]: http://burakdemirtas.org
[mit-url]: http://opensource.org/licenses/MIT
[doc-url]: https://github.com/izniburak/PDOx/blob/master/docs.md
[author-url]: http://burakdemirtas.org
[twitter-url]: https://twitter.com/izniburak

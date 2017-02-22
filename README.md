## PDOx
```
 _____  _____   ____       
 |  __ \|  __ \ / __ \      
 | |__) | |  | | |  | |_  __
 |  ___/| |  | | |  | \ \/ /
 | |    | |__| | |__| |>  <
 |_|    |_____/ \____//_/\_\
```
Fast, efficient and useful Query Builder and PDO Class for #PHP

[![Total Downloads](https://poser.pugx.org/izniburak/pdox/d/total.svg)](https://packagist.org/packages/izniburak/pdox)
[![Latest Stable Version](https://poser.pugx.org/izniburak/pdox/v/stable.svg)](https://packagist.org/packages/izniburak/pdox)
[![Latest Unstable Version](https://poser.pugx.org/izniburak/pdox/v/unstable.svg)](https://packagist.org/packages/izniburak/pdox)
[![License](https://poser.pugx.org/izniburak/pdox/license.svg)](https://packagist.org/packages/izniburak/pdox)

## Install

composer.json file:
```json
{
    "require": {
        "izniburak/pdox": "^1"
    }
}
```
after run the install command.
```
$ composer install
```

OR run the following command directly.

```
$ composer require izniburak/pdox
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

$db = new \Buki\Pdox($config);

$records = $db->table('users')
		->select('id, name, surname, age')
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

## Contributing

1. Fork it ( https://github.com/izniburak/pdox/fork )
2. Create your feature branch (git checkout -b my-new-feature)
3. Commit your changes (git commit -am 'Add some feature')
4. Push to the branch (git push origin my-new-feature)
5. Create a new Pull Request

## Contributors

- [izniburak](https://github.com/izniburak) İzni Burak Demirtaş - creator, maintainer

[pdox-img]: http://burakdemirtas.org/uploads/images/20140610210255_pdox_pdo_class_for_php.jpg
[paypal-donate-url]: http://burakdemirtas.org
[mit-url]: http://opensource.org/licenses/MIT
[doc-url]: https://github.com/izniburak/PDOx/blob/master/DOCS.md
[author-url]: http://burakdemirtas.org
[twitter-url]: https://twitter.com/izniburak

## PDOx
```
 _____  _____   ____       
 |  __ \|  __ \ / __ \      
 | |__) | |  | | |  | |_  __
 |  ___/| |  | | |  | \ \/ /
 | |    | |__| | |__| |>  <
 |_|    |_____/ \____//_/\_\
```
快速高效的PHP PDO查询构造器

[![Total Downloads](https://poser.pugx.org/izniburak/pdox/d/total.svg)](https://packagist.org/packages/izniburak/pdox)
[![Latest Stable Version](https://poser.pugx.org/izniburak/pdox/v/stable.svg)](https://packagist.org/packages/izniburak/pdox)
[![Latest Unstable Version](https://poser.pugx.org/izniburak/pdox/v/unstable.svg)](https://packagist.org/packages/izniburak/pdox)
[![License](https://poser.pugx.org/izniburak/pdox/license.svg)](https://packagist.org/packages/izniburak/pdox)

## 安装

composer.json file:
```json
{
    "require": {
        "izniburak/pdox": "^1"
    }
}
```
运行安装命令.
```
$ composer install
```

或者直接运行以下命令.

```
$ composer require izniburak/pdox
```

## 用法示例
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

## 文档
Documentation page: [PDOx Docs][doc-url]

## 支持
[izniburak's homepage][author-url]

[izniburak's twitter][twitter-url]

## 协议
[MIT Licence][mit-url]

## 贡献

1. Fork it ( https://github.com/izniburak/pdox/fork )
2. Create your feature branch (git checkout -b my-new-feature)
3. Commit your changes (git commit -am 'Add some feature')
4. Push to the branch (git push origin my-new-feature)
5. Create a new Pull Request

## 贡献者

- [izniburak](https://github.com/izniburak) İzni Burak Demirtaş - creator, maintainer

[pdox-img]: http://burakdemirtas.org/uploads/images/20140610210255_pdox_pdo_class_for_php.jpg
[paypal-donate-url]: http://burakdemirtas.org
[mit-url]: http://opensource.org/licenses/MIT
[doc-url]: https://github.com/imsole/PDOx/blob/master/DOCS.md
[author-url]: http://burakdemirtas.org
[twitter-url]: https://twitter.com/izniburak

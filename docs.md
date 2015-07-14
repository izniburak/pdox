# PDOx Documentation

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


## Quick Usage
```php
require 'vendor/autoload.php';

$config = [
	'host'      => 'localhost',
	'driver'    => 'mysql',
	'database'  => 'test',
	'username'	=> 'root',
	'password'  => '',
	'charset'   => 'utf8',
	'collation' => 'utf8_general_ci',
	'prefix'    => ''
];

$db = new \buki\PDOx($config);
```


Congratulations! Now, you can use PDOx.

If you have a problem, you can [contact me][support-url].




# Detailed Usage and Methods

## config 
```php
$config = [
	# Host name or IP Address (not required)
	# default value: localhost
	'host'      => 'localhost',
		
	# Database Driver Type (not required)
	# default value: mysql
	# values: mysql, pgsql, sqlite, oracle
	'driver'    => 'mysql',
		 
	# Database Name (required)
	'database'  => 'test',
		
	# Database User Name (required)
	'username'  => 'root',
		
	# Database User Password (required)
	'password'  => '',
		
	# Database Charset (not required)
	# default value: utf8
	'charset'   => 'utf8',
		
	# Database Charset Collation (not required)
	# default value: utf8_general_ci
	'collation' => 'utf8_general_ci',
		
	# Database Prefix (not required)
	# default value: null
	'prefix'     => ''
];

$db = new \buki\PDOx($config);
```

### select
```php
# Usage 1: string parameter
$db->select('title, content');
$db->select('title AS t, content AS c');

# Usage2: array parameter
$db->select(['title', 'content']);
$db->select(['title AS t', 'content AS c']);
```

### from
```php
# Usage 1: string parameter
$db->from('table');
$db->from('table1, table2');
$db->from('table1 AS t1, table2 AS t2');

# Usage2: array parameter
$db->select(['table1', 'table2']);
$db->select(['table1 AS t1', 'table2 AS t2']);
```

### get AND getAll
```php

```

### join
```php

```

### where
```php

```

### in
```php

```

### between
```php

```

### like
```php

```

### groupBy
```php

```

### having
```php

```

### orderBy
```php

```

### limit
```php

```

### insert
```php

```

### update
```php

```

### delete
```php

```

### query
```php

```

### insertId
```php

```

### count
```php

```

### error
```php

```

### escape
```php

```

[support-url]: https://github.com/izniburak/PDOx#support

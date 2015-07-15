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

### where - orWhere
```php
# Usage 1: array parameter
$where = [
	'name' => 'Burak',
	'age' => 23,
	'status' => 1
];
$db->where($where);

# Usage 2: 
$db->where('status', 2);
$db->where('status', 1)->where('name', 'burak');
$db->where('status', 1)->orWhere('status', 2);

# Usage 3:
$db->where('age', '>', 20);
$db->where('age', '>', 20)->orWhere('age', '<', 30);

# Usage 4: 
$db->where('status = ? AND age = ?', [1, 20]);
$db->where('status = ? AND title = ?', [0, 'example title']);
```

### in - notIn - orIn - orNotIn
```php
$db->in('page', ['about', 'contact', 'products']);
$db->orIn('id', [1, 2, 3]);
$db->notIn('age', [20, 21, 22, 23]);
$db->orNotIn('age', [30, 31, 32, 32]);
```

### between - orBetween - notBetween - orNotBetween
```php
$db->between('age', 10, 20);
$db->orBetween('age', 20, 30);
$db->notBetween('year', 2010, 2015);
$db->orNotBetween('year', 2005, 2009);
```

### like - orLike
```php
$db->like('title', 'burak');		// " title LIKE '%burak%' "
$db->like('title', 'izniburak', '-%');	// " title LIKE 'izniburak%' "
$db->like('title', 'izniburak', '%-');	// " title LIKE '%izniburak' "

$db->like('user', 'php')->orLike('user', 'web');
$db->like('user', 'php')->orLike('user', 'web', '-%');
$db->like('user', 'php')->orLike('user', 'web', '%-');
```

### groupBy
```php
$db->groupBy('country');
$db->groupBy('country, city');
```

### having
```php
$db->having('AVG(price)', 2000);	// " AVG(price) > 2000 "
$db->having('AVG(price)', '>=', 3000);	// " AVG(price) >= 3000 "
$db->having('SUM(age) <= ?', [50]);	// " SUM(age) <= 50 "
```

### orderBy
```php
$db->orderBy('id');	// " ORDER BY id ASC
$db->orderBy('id DESC');
$db->orderBy('id', 'desc');
$db->orderBy('rand()');	// " ORDER BY rand() "
```

### limit
```php
$db->limit(10);		// " LIMIT 10 "
$db->limit(10, 20);	// " LIMIT 10, 20 "
```

### insert
```php
$data = [
	'title' => 'test',
	'content' => 'Lorem ipsum dolor sit amet...',
	'time' => time(),
	'status' => 1
];

$db->from('pages')->insert($data);
```

### update
```php
$data = [
	'username' => 'izniburak',
	'password' => md5('demo-password'),
	'activation' => 1,
	'status' => 1
];

$db->from('users')->where('id', 10)->update($data);
```

### delete
```php
$db->from('users')->where('id', 5)->delete();
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

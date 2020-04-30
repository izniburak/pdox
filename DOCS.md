# PDOx Documentation

## Install
`composer.json` file:
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

## Quick Usage
```php
require 'vendor/autoload.php';

$config = [
	'driver'    => 'mysql',
	'host'      => 'localhost',
	'database'  => 'test',
	'username'  => 'root',
	'password'  => '',
	'charset'   => 'utf8',
	'collation' => 'utf8_general_ci',
	'prefix'    => ''
];

$db = new \Buki\Pdox($config);
```

Congratulations! Now, you can use PDOx.

If you have a problem, you can [contact me][support-url].

# Detailed Usage and Methods

## config
```php
$config = [
	# Database Driver Type (optional)
	# default value: mysql
	# values: mysql, pgsql, sqlite, oracle
	'driver'    => 'mysql',

	# Host name or IP Address (optional)
	# hostname:port (for Port Usage. Example: 127.0.0.1:1010)
	# default value: localhost
	'host'      => 'localhost',

	# IP Address for Database Host (optional)
	# default value: null
	'port'      => 3306,

	# Database Name (required)
	'database'  => 'test',

	# Database User Name (required)
	'username'  => 'root',

	# Database User Password (required)
	'password'  => '',

	# Database Charset (optional)
	# default value: utf8
	'charset'   => 'utf8',

	# Database Charset Collation (optional)
	# default value: utf8_general_ci
	'collation' => 'utf8_general_ci',

	# Database Prefix (optional)
	# default value: null
	'prefix'     => '',

	# Cache Directory of the Sql Result (optional)
	# default value: __DIR__ . '/cache/'
	'cachedir'	=> __DIR__ . '/cache/sql/'
];

$db = new \Buki\Pdox($config);
```

## Contents

 * [select](#select)
 * [select functions (min, max, sum, avg, count)](#select-functions-min-max-sum-avg-count)
 * [table](#table)
 * [get AND getAll](#get-and-getall)
 * [join](#join)
 * [where](#where)
 * [grouped](#grouped)
 * [in](#in)
 * [between](#between)
 * [like](#like)
 * [groupBy](#groupby)
 * [having](#having)
 * [orderBy](#orderby)
 * [limit - offset](#limit---offset)
 * [pagination](#pagination)
 * [insert](#insert)
 * [update](#update)
 * [delete](#delete)
 * [analyze](#analyze) - [check](#check) - [checksum](#checksum) - [optimize](#optimize) - [repair](#repair)
 * [query](#query)
 * [insertId](#insertid)
 * [numRows](#numrows)
 * [cache](#cache)
 * [transaction](#transaction) - [commit](#transaction) - [rollBack](#transaction)
 * [error](#error)
 * [queryCount](#querycount)
 * [getQuery](#getquery)

## Methods

### select
```php
# Usage 1: string parameter
$db->select('title, content')->table('test')->getAll();
# Output: "SELECT title, content FROM test"

$db->select('title AS t, content AS c')->table('test')->getAll();
# Output: "SELECT title AS t, content AS c FROM test"
```
```php
# Usage2: array parameter
$db->select(['title', 'content'])->table('test')->getAll();
# Output: "SELECT title, content FROM test"

$db->select(['title AS t', 'content AS c'])->table('test')->getAll();
# Output: "SELECT title AS t, content AS c FROM test"
```

### select functions (min, max, sum, avg, count)
```php
# Usage 1:
$db->table('test')->max('price')->get();
# Output: "SELECT MAX(price) FROM test"

# Usage 2:
$db->table('test')->count('id', 'total_row')->get();
# Output: "SELECT COUNT(id) AS total_row FROM test"
```

### table
```php
### Usage 1: string parameter
$db->table('table');
# Output: "SELECT * FROM table"

$db->table('table1, table2');
# Output: "SELECT * FROM table1, table2"

$db->table('table1 AS t1, table2 AS t2');
# Output: "SELECT * FROM table1 AS t1, table2 AS t2"
```
```php
### Usage 2: array parameter
$db->table(['table1', 'table2']);
# Output: "SELECT * FROM table1, table2"

$db->table(['table1 AS t1', 'table2 AS t2']);
# Output: "SELECT * FROM table1 AS t1, table2 AS t2"
```

### get AND getAll
```php
# get(): return 1 record.
# getAll(): return multiple records.

$db->table('test')->getAll(); 
# Output: "SELECT * FROM test"

$db->select('username')->table('users')->where('status', 1)->getAll();
# Output: "SELECT username FROM users WHERE status='1'"

$db->select('title')->table('pages')->where('id', 17)->get(); 
# Output: "SELECT title FROM pages WHERE id='17' LIMIT 1"
```

### join
```php
$db->table('test as t')->join('foo as f', 't.id', 'f.t_id')->where('t.status', 1)->getAll();
# Output: "SELECT * FROM test as t JOIN foo as f ON t.id=f.t_id WHERE t.status='1'"
```
You can use this method in 7 ways. These;
- join
- left_join
- right_join
- inner_join
- full_outer_join
- left_outer_join
- right_outer_join

Examples:
```php
$db->table('test as t')->leftJoin('foo as f', 't.id', 'f.t_id')->getAll();
# Output: "SELECT * FROM test as t LEFT JOIN foo as f ON t.id=f.t_id"
```

```php
$db->table('test as t')->fullOuterJoin('foo as f', 't.id', 'f.t_id')->getAll();
# Output: "SELECT * FROM test as t FULL OUTER JOIN foo as f ON t.id=f.t_id"
```

### where
```php
$where = [
	'name' => 'Burak',
	'age' => 23,
	'status' => 1
];
$db->table('test')->where($where)->get();
# Output: "SELECT * FROM test WHERE name='Burak' AND age='23' AND status='1' LIMIT 1"

# OR

$db->table('test')->where('active', 1)->getAll();
# Output: "SELECT * FROM test WHERE active='1'"

# OR

$db->table('test')->where('age', '>=', 18)->getAll();
# Output: "SELECT * FROM test WHERE age>='18'"

# OR

$db->table('test')->where('age = ? OR age = ?', [18, 20])->getAll();
# Output: "SELECT * FROM test WHERE age='18' OR age='20'"
```

You can use this method in 4 ways. These;

- where
- orWhere
- notWhere
- orNotWhere
- whereNull
- whereNotNull

Example:
```php
$db->table('test')->where('active', 1)->notWhere('auth', 1)->getAll();
# Output: "SELECT * FROM test WHERE active = '1' AND NOT auth = '1'"

# OR

$db->table('test')->where('age', 20)->orWhere('age', '>', 25)->getAll();
# Output: "SELECT * FROM test WHERE age = '20' OR age > '25'"

$db->table('test')->whereNotNull('email')->getAll();
# Output: "SELECT * FROM test WHERE email IS NOT NULL"
```

### grouped
```php
$db->table('users')
	->grouped(function($q) {
		$q->where('country', 'TURKEY')->orWhere('country', 'ENGLAND');
	})
	->where('status', 1)
	->getAll();
# Ouput: "SELECT * FROM users WHERE (country='TURKEY' OR country='ENGLAND') AND status ='1'"
```

### in
```php
$db->table('test')->where('active', 1)->in('id', [1, 2, 3])->getAll();
# Output: "SELECT * FROM test WHERE active = '1' AND id IN ('1', '2', '3')"
```

You can use this method in 4 ways. These;

- in
- orIn
- notIn
- orNotIn

Example:
```php
$db->table('test')->where('active', 1)->notIn('id', [1, 2, 3])->getAll();
# Output: "SELECT * FROM test WHERE active = '1' AND id NOT IN ('1', '2', '3')"

# OR

$db->table('test')->where('active', 1)->orIn('id', [1, 2, 3])->getAll();
# Output: "SELECT * FROM test WHERE active = '1' OR id IN ('1', '2', '3')"
```

### between
```php
$db->table('test')->where('active', 1)->between('age', 18, 25)->getAll();
# Output: "SELECT * FROM test WHERE active = '1' AND age BETWEEN '18' AND '25'"
```

You can use this method in 4 ways. These;

- between
- orBetween
- notBetween
- orNotBetween

Example:
```php
$db->table('test')->where('active', 1)->notBetween('age', 18, 25)->getAll();
# Output: "SELECT * FROM test WHERE active = '1' AND age NOT BETWEEN '18' AND '25'"

# OR

$db->table('test')->where('active', 1)->orBetween('age', 18, 25)->getAll();
# Output: "SELECT * FROM test WHERE active = '1' OR age BETWEEN '18' AND '25'"
```

### like
```php
$db->table('test')->like('title', "%php%")->getAll();
# Output: "SELECT * FROM test WHERE title LIKE '%php%'"
```

You can use this method in 4 ways. These;

- like
- orLike
- notLike
- orNotLike

Example:
```php
$db->table('test')->where('active', 1)->notLike('tags', '%dot-net%')->getAll();
# Output: "SELECT * FROM test WHERE active = '1' AND tags NOT LIKE '%dot-net%'"

# OR

$db->table('test')->like('bio', '%php%')->orLike('bio', '%java%')->getAll();
# Output: "SELECT * FROM test WHERE bio LIKE '%php%' OR bio LIKE '%java%'"
```

### groupBy
```php
# Usage 1: One parameter
$db->table('test')->where('status', 1)->groupBy('cat_id')->getAll();
# Output: "SELECT * FROM test WHERE status = '1' GROUP BY cat_id"
```

```php
# Usage 1: Array parameter
$db->table('test')->where('status', 1)->groupBy(['cat_id', 'user_id'])->getAll();
# Output: "SELECT * FROM test WHERE status = '1' GROUP BY cat_id, user_id"
```

### having
```php
$db->table('test')->where('status', 1)->groupBy('city')->having('COUNT(person)', 100)->getAll();
# Output: "SELECT * FROM test WHERE status='1' GROUP BY city HAVING COUNT(person) > '100'"

# OR

$db->table('test')->where('active', 1)->groupBy('department_id')->having('AVG(salary)', '<=', 500)->getAll();
# Output: "SELECT * FROM test WHERE active='1' GROUP BY department_id HAVING AVG(salary) <= '500'"

# OR

$db->table('test')->where('active', 1)->groupBy('department_id')->having('AVG(salary) > ? AND MAX(salary) < ?', [250, 1000])->getAll();
# Output: "SELECT * FROM test WHERE active='1' GROUP BY department_id HAVING AVG(salary) > '250' AND MAX(salary) < '1000'"
```

### orderBy
```php
# Usage 1: One parameter
$db->table('test')->where('status', 1)->orderBy('id')->getAll();
# Output: "SELECT * FROM test WHERE status='1' ORDER BY id ASC"

### OR

$db->table('test')->where('status', 1)->orderBy('id desc')->getAll();
# Output: "SELECT * FROM test WHERE status='1' ORDER BY id desc"
```

```php
# Usage 1: Two parameters
$db->table('test')->where('status', 1)->orderBy('id', 'desc')->getAll();
# Output: "SELECT * FROM test WHERE status='1' ORDER BY id DESC"
```

```php
# Usage 3: Rand()
$db->table('test')->where('status', 1)->orderBy('rand()')->limit(10)->getAll();
# Output: "SELECT * FROM test WHERE status='1' ORDER BY rand() LIMIT 10"
```

### limit - offset
```php
# Usage 1: One parameter
$db->table('test')->limit(10)->getAll();
# Output: "SELECT * FROM test LIMIT 10"
```
```php
# Usage 2: Two parameters
$db->table('test')->limit(10, 20)->getAll();
# Output: "SELECT * FROM test LIMIT 10, 20"

# Usage 3: with offset method
$db->table('test')->limit(10)->offset(10)->getAll();
# Output: "SELECT * FROM test LIMIT 10 OFFSET 10"
```

### pagination
```php
# First parameter: Data count of per page
# Second parameter: Active page

$db->table('test')->pagination(15, 1)->getAll();
# Output: "SELECT * FROM test LIMIT 15 OFFSET 0"

$db->table('test')->pagination(15, 2)->getAll();
# Output: "SELECT * FROM test LIMIT 15 OFFSET 15"
```

### insert
```php
$data = [
	'title' => 'test',
	'content' => 'Lorem ipsum dolor sit amet...',
	'time' => '2017-05-19 19:05:00',
	'status' => 1
];

$db->table('pages')->insert($data);
# Output: "INSERT INTO test (title, content, time, status) VALUES ('test', 'Lorem ipsum dolor sit amet...', '2017-05-19 19:05:00', '1')"
```

### update
```php
$data = [
	'username' => 'izniburak',
	'password' => 'pass',
	'activation' => 1,
	'status' => 1
];

$db->table('users')->where('id', 10)->update($data);
# Output: "UPDATE users SET username='izniburak', password='pass', activation='1', status='1' WHERE id='10'"
```

### delete
```php
$db->table('test')->where("id", 17)->delete();
# Output: "DELETE FROM test WHERE id = '17'"

# OR

$db->table('test')->delete();
# Output: "TRUNCATE TABLE delete"
```

### transaction
```php
$db->transaction();

$data = [
	'title' => 'new title',
	'status' => 2
];
$db->table('test')->where('id', 10)->update($data);

$db->commit();
# OR
$db->rollBack();
```

### analyze
```php
$db->table('users')->analyze();
# Output: "ANALYZE TABLE users"
```

### check
```php
$db->table(['users', 'pages'])->check();
# Output: "CHECK TABLE users, pages"
```

### checksum
```php
$db->table(['users', 'pages'])->checksum();
# Output: "CHECKSUM TABLE users, pages"
```

### optimize
```php
$db->table(['users', 'pages'])->optimize();
# Output: "OPTIMIZE TABLE users, pages"
```

### repair
```php
$db->table(['users', 'pages'])->repair();
# Output: "REPAIR TABLE users, pages"
```

### query
```php
# Usage 1: Select all records
$db->query('SELECT * FROM test WHERE id=? AND status=?', [10, 1])->fetchAll();

# Usage 2: Select one record
$db->query('SELECT * FROM test WHERE id=? AND status=?', [10, 1])->fetch();

# Usage 3: Other queries like Update, Insert, Delete etc...
$db->query('DELETE FROM test WHERE id=?', [10])->exec();
```

### insertId
```php
$data = [
	'title' => 'test',
	'content' => 'Lorem ipsum dolor sit amet...',
	'time' => time(),
	'status' => 1
];
$db->table('pages')->insert($data);

var_dump($db->insertId());
```

### numRows
```php
$db->select('id, title')->table('test')->where('status', 1)->orWhere('status', 2)->getAll();

var_dump($db->numRows());
```

### error
```php
$db->error();
```

### cache
```php
# Usage: ...->cache($time)->...
$db->table('pages')->where('slug', 'example-page')->cache(60)->get(); 
# cache time: 60 seconds
```

### queryCount
```php
$db->queryCount(); 
# The number of all SQL queries on the page until the end of the beginning.
```

### getQuery
```php
$db->getQuery(); 
# Last SQL Query.
```

[support-url]: https://github.com/izniburak/PDOx#support

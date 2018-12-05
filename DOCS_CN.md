# PDOx 文档

## 安装
`composer.json` file:
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

或者直接运行以下命令..

```
$ composer require izniburak/pdox
```

## 快速入门
```php
require 'vendor/autoload.php';

$config = [
	'host'      => 'localhost',
	'driver'    => 'mysql',
	'database'  => 'test',
	'username'  => 'root',
	'password'  => '',
	'charset'   => 'utf8',
	'collation' => 'utf8_general_ci',
	'prefix'    => ''
];

$db = new \Buki\Pdox($config);
```

恭喜！现在，您可以使用PDOx。

如果您有问题，可以与我[联系][support-url].

# 详细的使用方法

## 配置
```php
$config = [
	# Host name or IP Address (optional)
	# hostname:port (for Port 用法. 例如： 127.0.0.1:1010)
	# default value: localhost
	'host'      => 'localhost',

	# Database Driver Type (optional)
	# default value: mysql
	# values: mysql, pgsql, sqlite, oracle
	'driver'    => 'mysql',

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

## 方法列表

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

## 方法

### select
```php
# 用法 1: 参数为字符串
$db->select('title, content')->table('test')->getAll();
# 输出: "SELECT title, content FROM test"

$db->select('title AS t, content AS c')->table('test')->getAll();
# 输出: "SELECT title AS t, content AS c FROM test"
```
```php
# 用法2: 参数为数组
$db->select(['title', 'content'])->table('test')->getAll();
# 输出: "SELECT title, content FROM test"

$db->select(['title AS t', 'content AS c'])->table('test')->getAll();
# 输出: "SELECT title AS t, content AS c FROM test"
```

### select functions (min, max, sum, avg, count)
```php
# 用法 1:
$db->table('test')->max('price')->get();
# 输出: "SELECT MAX(price) FROM test"

# 用法 2:
$db->table('test')->count('id', 'total_row')->get();
# 输出: "SELECT COUNT(id) AS total_row FROM test"
```

### table
```php
### 用法 1: 参数为字符串
$db->table('table');
# 输出: "SELECT * FROM table"

$db->table('table1, table2');
# 输出: "SELECT * FROM table1, table2"

$db->table('table1 AS t1, table2 AS t2');
# 输出: "SELECT * FROM table1 AS t1, table2 AS t2"
```
```php
### 用法 2: 参数为数组
$db->table(['table1', 'table2']);
# 输出: "SELECT * FROM table1, table2"

$db->table(['table1 AS t1', 'table2 AS t2']);
# 输出: "SELECT * FROM table1 AS t1, table2 AS t2"
```

### get AND getAll
```php
# get(): return 1 record.
# getAll(): return multiple records.

$db->table('test')->getAll(); 
# 输出: "SELECT * FROM test"

$db->select('username')->table('users')->where('status', 1)->getAll();
# 输出: "SELECT username FROM users WHERE status='1'"

$db->select('title')->table('pages')->where('id', 17)->get(); 
# 输出: "SELECT title FROM pages WHERE id='17' LIMIT 1"
```

### join
```php
$db->table('test as t')->join('foo as f', 't.id', 'f.t_id')->where('t.status', 1)->getAll();
# 输出: "SELECT * FROM test as t JOIN foo as f ON t.id=f.t_id WHERE t.status='1'"
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
# 输出: "SELECT * FROM test as t LEFT JOIN foo as f ON t.id=f.t_id"
```

```php
$db->table('test as t')->fullOuterJoin('foo as f', 't.id', 'f.t_id')->getAll();
# 输出: "SELECT * FROM test as t FULL OUTER JOIN foo as f ON t.id=f.t_id"
```

### where
```php
$where = [
	'name' => 'Burak',
	'age' => 23,
	'status' => 1
];
$db->table('test')->where($where)->get();
# 输出: "SELECT * FROM test WHERE name='Burak' AND age='23' AND status='1' LIMIT 1"

# OR

$db->table('test')->where('active', 1)->getAll();
# 输出: "SELECT * FROM test WHERE active='1'"

# OR

$db->table('test')->where('age', '>=', 18)->getAll();
# 输出: "SELECT * FROM test WHERE age>='18'"

# OR

$db->table('test')->where('age = ? OR age = ?', [18, 20])->getAll();
# 输出: "SELECT * FROM test WHERE age='18' OR age='20'"
```

其他方法：

- where
- orWhere
- notWhere
- orNotWhere
- whereNull
- whereNotNull

例如：
```php
$db->table('test')->where('active', 1)->notWhere('auth', 1)->getAll();
# 输出: "SELECT * FROM test WHERE active = '1' AND NOT auth = '1'"

# OR

$db->table('test')->where('age', 20)->orWhere('age', '>', 25)->getAll();
# 输出: "SELECT * FROM test WHERE age = '20' OR age > '25'"

$db->table('test')->whereNotNull('email')->getAll();
# 输出: "SELECT * FROM test WHERE email IS NOT NULL"
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
# 输出: "SELECT * FROM test WHERE active = '1' AND id IN ('1', '2', '3')"
```

其他方法：

- in
- orIn
- notIn
- orNotIn

例如：
```php
$db->table('test')->where('active', 1)->notIn('id', [1, 2, 3])->getAll();
# 输出: "SELECT * FROM test WHERE active = '1' AND id NOT IN ('1', '2', '3')"

# OR

$db->table('test')->where('active', 1)->orIn('id', [1, 2, 3])->getAll();
# 输出: "SELECT * FROM test WHERE active = '1' OR id IN ('1', '2', '3')"
```

### between
```php
$db->table('test')->where('active', 1)->between('age', 18, 25)->getAll();
# 输出: "SELECT * FROM test WHERE active = '1' AND age BETWEEN '18' AND '25'"
```

其他方法：

- between
- orBetween
- notBetween
- orNotBetween

例如：
```php
$db->table('test')->where('active', 1)->notBetween('age', 18, 25)->getAll();
# 输出: "SELECT * FROM test WHERE active = '1' AND age NOT BETWEEN '18' AND '25'"

# OR

$db->table('test')->where('active', 1)->orBetween('age', 18, 25)->getAll();
# 输出: "SELECT * FROM test WHERE active = '1' OR age BETWEEN '18' AND '25'"
```

### like
```php
$db->table('test')->like('title', "%php%")->getAll();
# 输出: "SELECT * FROM test WHERE title LIKE '%php%'"
```

其他方法：

- like
- orLike
- notLike
- orNotLike

例如：
```php
$db->table('test')->where('active', 1)->notLike('tags', '%dot-net%')->getAll();
# 输出: "SELECT * FROM test WHERE active = '1' AND tags NOT LIKE '%dot-net%'"

# OR

$db->table('test')->like('bio', '%php%')->orLike('bio', '%java%')->getAll();
# 输出: "SELECT * FROM test WHERE bio LIKE '%php%' OR bio LIKE '%java%'"
```

### groupBy
```php
# 用法 1: 一个参数
$db->table('test')->where('status', 1)->groupBy('cat_id')->getAll();
# 输出: "SELECT * FROM test WHERE status = '1' GROUP BY cat_id"
```

```php
# 用法 1: 参数为数组
$db->table('test')->where('status', 1)->groupBy(['cat_id', 'user_id'])->getAll();
# 输出: "SELECT * FROM test WHERE status = '1' GROUP BY cat_id, user_id"
```

### having
```php
$db->table('test')->where('status', 1)->groupBy('city')->having('COUNT(person)', 100)->getAll();
# 输出: "SELECT * FROM test WHERE status='1' GROUP BY city HAVING COUNT(person) > '100'"

# OR

$db->table('test')->where('active', 1)->groupBy('department_id')->having('AVG(salary)', '<=', 500)->getAll();
# 输出: "SELECT * FROM test WHERE active='1' GROUP BY department_id HAVING AVG(salary) <= '500'"

# OR

$db->table('test')->where('active', 1)->groupBy('department_id')->having('AVG(salary) > ? AND MAX(salary) < ?', [250, 1000])->getAll();
# 输出: "SELECT * FROM test WHERE active='1' GROUP BY department_id HAVING AVG(salary) > '250' AND MAX(salary) < '1000'"
```

### orderBy
```php
# 用法 1: 一个参数
$db->table('test')->where('status', 1)->orderBy('id')->getAll();
# 输出: "SELECT * FROM test WHERE status='1' ORDER BY id ASC"

### OR

$db->table('test')->where('status', 1)->orderBy('id desc')->getAll();
# 输出: "SELECT * FROM test WHERE status='1' ORDER BY id desc"
```

```php
# 用法 1: 两个参数
$db->table('test')->where('status', 1)->orderBy('id', 'desc')->getAll();
# 输出: "SELECT * FROM test WHERE status='1' ORDER BY id DESC"
```

```php
# 用法 3: Rand()
$db->table('test')->where('status', 1)->orderBy('rand()')->limit(10)->getAll();
# 输出: "SELECT * FROM test WHERE status='1' ORDER BY rand() LIMIT 10"
```

### limit - offset
```php
# 用法 1: 一个参数
$db->table('test')->limit(10)->getAll();
# 输出: "SELECT * FROM test LIMIT 10"
```
```php
# 用法 2: 两个参数
$db->table('test')->limit(10, 20)->getAll();
# 输出: "SELECT * FROM test LIMIT 10, 20"

# 用法 3: offset的使用
$db->table('test')->limit(10)->offset(10)->getAll();
# 输出: "SELECT * FROM test LIMIT 10 OFFSET 10"
```

### pagination
```php
# 参数1: 每个页面显示的数量
# 参数2: 第几页

$db->table('test')->pagination(15, 1)->getAll();
# 输出: "SELECT * FROM test LIMIT 15 OFFSET 0"

$db->table('test')->pagination(15, 2)->getAll();
# 输出: "SELECT * FROM test LIMIT 15 OFFSET 15"
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
# 输出: "INSERT INTO test (title, content, time, status) VALUES ('test', 'Lorem ipsum dolor sit amet...', '2017-05-19 19:05:00', '1')"
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
# 输出: "UPDATE users SET username='izniburak', password='pass', activation='1', status='1' WHERE id='10'"
```

### delete
```php
$db->table('test')->where("id", 17)->delete();
# 输出: "DELETE FROM test WHERE id = '17'"

# OR

$db->table('test')->delete();
# 输出: "TRUNCATE TABLE delete"
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
# 输出: "ANALYZE TABLE users"
```

### check
```php
$db->table(['users', 'pages'])->check();
# 输出: "CHECK TABLE users, pages"
```

### checksum
```php
$db->table(['users', 'pages'])->checksum();
# 输出: "CHECKSUM TABLE users, pages"
```

### optimize
```php
$db->table(['users', 'pages'])->optimize();
# 输出: "OPTIMIZE TABLE users, pages"
```

### repair
```php
$db->table(['users', 'pages'])->repair();
# 输出: "REPAIR TABLE users, pages"
```

### query
```php
# 用法 1: 查询所有记录
$db->query('SELECT * FROM test WHERE id=? AND status=?', [10, 1])->fetchAll();

# 用法 2: 查询一条记录
$db->query('SELECT * FROM test WHERE id=? AND status=?', [10, 1])->fetch();

# 用法 3: 其他查询，比如 更新, 插入, 删除 ...
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
# 用法: ...->cache($time)->...
$db->table('pages')->where('slug', 'example-page')->cache(60)->get(); 
# 缓存时间: 60 seconds
```

### queryCount
```php
$db->queryCount(); 
# 一个页面上所有的查询总数量.
```

### getQuery
```php
$db->getQuery(); 
# Last SQL Query.
```

[support-url]: https://github.com/izniburak/PDOx#support

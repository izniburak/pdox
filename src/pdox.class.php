<?php
/*
*
* PHP PDO Database Class for MySQL, PostgreSQL, SQLite and Oracle
*
* @ Author: izni burak demirtas / @izniburak <info@burakdemirtas.org>
*
* @ Web: http://burakdemirtas.org
*
* @ URL: https://github.com/izniburak/PDOx
*
* @ Licence: The MIT License (MIT) - Copyright (c) - http://opensource.org/licenses/MIT
*
*/

namespace buki;

class PDOx
{
	public $pdo = null;
	
	private $select = '*';
	private $from = null;
	private $where = null;
	private $limit = null;
	private $join = null;
	private $order_by = null;
	private $group_by = null;
	private $having = null;
	private $num_rows = 0;
	private $insert_id = null;
	private $query = null;
	private $error = null;
	private $result = [];
	private $prefix = null;
	private $op = ['=','!=','<','>','<=','>=','<>'];

	public function __construct($config)
	{
		$config['driver'] 	= ((@$config['driver']) ? $config['driver'] : 'mysql');
		$config['host'] 	= ((@$config['host']) ? $config['host'] : 'localhost');
		$config['charset'] 	= ((@$config['charset']) ? $config['charset'] : 'utf8');
		$config['collation']	= ((@$config['collation']) ? $config['collation'] : 'utf8_general_ci');
		$config['prefix'] 	= ((@$config['prefix']) ? $config['prefix'] : '');
		$this->prefix		= $config['prefix'];
	
		$dsn = '';
	
		if ($config['driver'] == 'mysql' || $config['driver'] == '' || $config['driver'] == 'pgsql')
			$dsn = $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'];
			
		elseif ($config['driver'] == 'sqlite')
			$dsn = 'sqlite:' . $config['database'] . ($config['database'] == ':memory:' ? '' : '.sqlite');
				
		elseif($config['driver'] == 'oracle') 
			$dsn = 'oci:dbname=' . $config['host'] . '/' . $config['database'];

		try
		{
			$this->pdo = new \PDO($dsn, $config['username'], $config['password']);
			
			$charset	= $config['charset'];
			$collation	= $config['collation'];
			
			$this->pdo->exec("SET NAMES '".$charset."' COLLATE '".$collation."'");
			$this->pdo->exec("SET CHARACTER SET '".$charset."'");
			$this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
		} 
		catch (\PDOException $e)
		{
			die('Cannot the connect to Database with PDO.<br /><br />'.$e->getMessage());
		}

		return $this->pdo;
	}
	
	public function select($select)
	{
		if(is_array($select))
			$this->select = implode(', ', $select);
		else
			$this->select = $select;
		
		return $this;
	}

	public function from($from)
	{
		if(is_array($from))
		{
			$f = '';
			foreach($from as $key)
				$f .= $this->prefix . $key . ', ';

			$this->from = rtrim($f, ', ');
		}
		else
			$this->from = $this->prefix . $from;
		
		return $this;
	}
	
	public function join($table, $field1, $op = null, $field2 = null, $join = 'INNER')
	{
		$where = $field1;
		$table = $this->prefix . $table;
		
		if(!is_null($op)) 
			$where = (!in_array($op, $this->op) ? $this->prefix . $field1 . ' = ' . $this->prefix . $op : $this->prefix . $field1 . ' ' . $op . ' ' . $this->prefix . $field2);
	
		if (is_null($this->join))
			$this->join = " " . $join . " JOIN" . " " . $table . " ON " . $where;
			
		else
			$this->join = $this->join . " " . $join . " JOIN" . " " . $table . " ON " . $where;
		
		return $this;
	}
	
	public function leftJoin($table, $field1, $op = '', $field2 = '')
	{
		$this->join($table, $field1, $op, $field2, 'LEFT');

		return $this;
	}
	
	public function rightJoin($table, $field1, $op = '', $field2 = '')
	{
		$this->join($table, $field1, $op, $field2, 'RIGHT');
		
		return $this;
	}

	public function where($where, $op = null, $val = null, $ao = 'AND')
	{
		if (is_array($where))
		{
			$_where = [];
			
			foreach ($where as $column => $data) 
				$_where[] = $column . '=' . $this->escape($data);
				
			$where = implode(' '.$ao.' ', $_where);
		}
		else
		{
			if(is_array($op))
			{
				$x = explode('?', $where);
				$w = '';
				foreach($x as $k => $v)
					if(!empty($v))
						$w .= $v . (isset($op[$k]) ? $this->escape($op[$k]) : '');

				$where = $w;
			}
			elseif (!in_array($op, $this->op))
				$where = $where . ' = ' . $this->escape($op);
			
			else
				$where = $where . ' ' . $op . ' ' . $this->escape($val);
		}
		
		if (is_null($this->where))
			$this->where = $where;
			
		else
			$this->where = $this->where . ' '.$ao.' ' . $where;

		return $this;
	}

	public function orWhere($where, $op=null, $val=null)
	{
		$this->where($where, $op, $val, 'OR');
		
		return $this;
	}
	
	public function in($field, $keys, $not = '', $ao = 'AND')
	{
		if (is_array($keys))
		{
			$_keys = [];
			
			foreach ($keys as $k => $v)
				$_keys[] = (is_numeric($v) ? $v : $this->escape($v));
			
			$keys = implode(', ', $_keys);
			
			if (is_null($this->where)) 
				$this->where = $field . ' ' . $not . 'IN (' . $keys . ')';
			
			else 
				$this->where = $this->where . ' ' . $ao . ' ' . $field . ' '.$not.'IN (' . $keys . ')';
		}
		
		return $this;
	}
	
	public function notIn($field, $keys)
	{
		$this->in($field, $keys, 'NOT ', 'AND');
		
		return $this;
	}

	public function orIn($field, $keys)
	{
		$this->in($field, $keys, '', 'OR');
		
		return $this;
	}

	public function orNotIn($field, $keys)
	{
		$this->in($field, $keys, 'NOT ', 'OR');
		
		return $this;
	}
	
	public function between($field, $value1, $value2, $not = '', $ao = 'AND')
	{
		if (is_null($this->where)) 
			$this->where = $field . ' ' . $not . 'BETWEEN ' . $this->escape($value1) . ' AND ' . $this->escape($value2);
		
		else 
			$this->where = $this->where . ' ' . $ao . ' ' . $field . ' ' . $not . 'BETWEEN ' . $this->escape($value1) . ' AND ' . $this->escape($value2);

		return $this;
	}
	
	public function notBetween($field, $value1, $value2)
	{
		$this->between($field, $value1, $value2, 'NOT ', 'AND');
		
		return $this;
	}

	public function orBetween($field, $value1, $value2)
	{
		$this->between($field, $value1, $value2, '', 'OR');
		
		return $this;
	}

	public function orNotBetween($field, $value1, $value2)
	{
		$this->between($field, $value1, $value2, 'NOT ', 'OR');
		
		return $this;
	}
	
	public function like($field, $data, $type = '%-%', $ao = 'AND')
	{
		$like = '';
		
		if($type == '-%')
			$like = $data.'%';
		
		elseif($type == '%-')
			$like = '%'.$data;
		
		else 
			$like = '%'.$data.'%';
	
		$like = $this->escape($like);
		
		if (is_null($this->where))
			$this->where = $field . ' LIKE ' . $like;
			
		else
			$this->where = $this->where . ' '.$ao.' ' . $field . ' LIKE ' . $like;
		
		return $this;
	}
	
	public function orLike($field, $data, $type = '%-%')
	{
		$this->like($field, $data, $type, 'OR');
		
		return $this;
	}

	public function limit($limit, $limitEnd = null)
	{
		if (!is_null($limitEnd))
			$this->limit = $limit . ', ' . $limitEnd;
			
		else
			$this->limit = $limit;
		
		return $this;
	}

	public function orderBy($order_by, $order_dir = null)
	{
		if (!is_null($order_dir))
			$this->order_by = $order_by . ' ' . $order_dir;
			
		else
		{
			if(stristr($order_by, ' ') || $order_by == 'rand()')
				$this->order_by = $order_by;
				
			else
				$this->order_by = $order_by . ' ASC';
		}
		
		return $this;
	}

	public function groupBy($group_by)
	{
		$this->group_by = $group_by;
		
		return $this;
	}
	
	public function having($field, $op = null, $val = null)
	{
		if(is_array($op))
		{
			$x = explode('?', $field);
			$w = '';
			foreach($x as $k => $v)
				if(!empty($v))
					$w .= $v . (isset($op[$k]) ? $this->escape($op[$k]) : '');

			$this->having = $w;
		}
		elseif (!in_array($op, $this->op))
			$this->having = $field . ' > ' . $this->escape($op);
		else
			$this->having = $field . ' ' . $op . ' ' . $this->escape($val);

		return $this;
	}

	public function count()
	{
		return $this->num_rows;
	}
	
	public function insertId()
	{
		return $this->insert_id;
	}

	public function error()
	{
		$msg = '<h1>Database Error</h1>';
		$msg .= '<h4>Query: <em style="font-weight:normal;">"'.$this->query.'"</em></h4>';
		$msg .= '<h4>Error: <em style="font-weight:normal;">'.$this->error.'</em></h4>';
		die($msg);
	}
	
	public function get($array = false)
	{
		$query = "SELECT " . $this->select . " FROM " . $this->from;
		
		if (!is_null($this->join))
			$query = $query . $this->join;

		if (!is_null($this->where)) 
			$query = $query . ' WHERE ' . $this->where;
			
		if (!is_null($this->group_by))
			$query = $query . " GROUP BY " . $this->group_by;

		if (!is_null($this->having)) 
			$query = $query . " HAVING " . $this->having;

		if (!is_null($this->order_by))
			$query = $query . " ORDER BY " . $this->order_by;

		$query  = $query . ' LIMIT 1';
		
		return $this->query($query, $array, false);
	}

	public function getAll($array = false)
	{
		$query = "SELECT " . $this->select . " FROM " . $this->from;
		
		if (!is_null($this->join))
			$query = $query . $this->join;
		
		if (!is_null($this->where))
			$query = $query . ' WHERE ' . $this->where;
		
		if (!is_null($this->group_by))
			$query = $query . " GROUP BY " . $this->group_by;
		
		if (!is_null($this->having)) 
			$query = $query . " HAVING " . $this->having;
		
		if (!is_null($this->order_by)) 
			$query = $query . " ORDER BY " . $this->order_by;
		
		$query = (!is_null($this->limit)) ? $query . "  LIMIT " . $this->limit : $query;
		
		return $this->query($query, $array);
	}

	public function insert($data)
	{
		$columns = array_keys($data);
		$column = implode(',', $columns);
		$val = "" . implode(", ", array_map([$this, 'escape'], $data)) . "";
		
		$query = 'INSERT INTO ' . $this->from . ' (' . $column . ') VALUES (' . $val . ')';
		$query = $this->query($query);
		
		if ($query)
		{
			$this->insert_id = $this->pdo->lastInsertId();
			
			return $this->insertId();
		}
		else 
			return false;
	}

	public function update($data)
	{
		$query = "UPDATE " . $this->from . " SET ";
		
		$values = [];
		
		foreach ($data as $column => $val)
			$values[] = $column . "=" . $this->escape($val) . "";

		$query = $query . (is_array($data) ? implode(',', $values) : $data);
		
		if (!is_null($this->where)) 
			$query = $query . ' WHERE ' . $this->where;
		
		if (!is_null($this->order_by))
			$query = $query . " ORDER BY " . $this->order_by;

		$query = (!is_null($this->limit)) ? $query . "  LIMIT " . $this->limit : $query;
		
		return $this->query($query);
	}

	public function delete()
	{
		$query = "DELETE FROM " . $this->from;
		
		if (!is_null($this->where))
		{
			$query = $query . ' WHERE ' . $this->where;
			
			if (!is_null($this->order_by))
				$query = $query . " ORDER BY " . $this->order_by;
			
			$query = (!is_null($this->limit)) ? $query . "  LIMIT " . $this->limit : $query;
		}
		else
			$query = 'TRUNCATE TABLE ' . $this->from;
		
		return $this->query($query);
	}
	
	public function query($query, $array = false, $all = true)
	{
		$this->reset();	
		$this->query = preg_replace('/\s\s+|\t\t+/', ' ', trim($query));
		$str = stristr($this->query, 'SELECT');
		
		if ($str)
		{
			$sql = $this->pdo->query($this->query);
			
			if ($sql)
			{
				$this->num_rows = $sql->rowCount();
				
				if (($this->num_rows > 0))
				{
					if ($all)
					{
						while ($result = ($array == false) ? $sql->fetchAll(\PDO::FETCH_OBJ) : $sql->fetchAll(\PDO::FETCH_ASSOC))
							$q[] = $result;
						
						$this->result = $q[0];
					}
					
					else
					{
						$q = ($array == false) ? $sql->fetch(\PDO::FETCH_OBJ) : $sql->fetch(\PDO::FETCH_ASSOC);
						$this->result = $q;
					}
				}
			}
			
			else
			{
				$this->error = $this->pdo->errorInfo();
				$this->error = $this->error[2];
				
				return $this->error();
			}
		}
		
		elseif(!$str)
		{
			$this->result = $this->pdo->query($this->query);
			
			if(!$this->result)
			{
				$this->error = $this->pdo->errorInfo();
				$this->error = $this->error[2];
				
				return $this->error();
			}
		}
		
		return $this->result;
	}
	
	public function escape($data)
	{
		return $this->pdo->quote(trim($data));
	}
	
	private function reset() 
	{
		$this->select = '*';
		$this->from = null;
		$this->where = null;
		$this->limit = null;
		$this->order_by = null;
		$this->group_by = null;
		$this->having = null;
		$this->join = null;
		$this->num_rows = 0;
		$this->insert_id = null;
		$this->query = null;
		$this->error = null;
		$this->result = [];
		
		return;
	}
	
	function __destruct()
	{
		$this->pdo = null;
	}
}

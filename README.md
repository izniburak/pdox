PDOx
====

Useful PHP PDO Class


Example
====
// config values
	$config = array(

		/*
		** Database User Name (required)
		*/
		
		'user'		=> 'root',
		
		/*
		** Database User Password (required)
		*/
		
		'pass'		=> '',
		
		/* 
		** Database Name (required)
		*/
		
		'dbname'	=> 'test',
		
		/*
		** Host name or IP Address (not required)
		** default value: localhost
		*/
		
		'host'		=> 'localhost',
		
		/* Database Driver Type (not required)
		** default value: mysql
		** values: mysql, pgsql, sqlite
		*/
		
		'type'		=> 'mysql',
		
		/* Database Charset (not required)
		** default value: utf8
		*/
		
		'charset'	=> 'utf8'
		
	);

	
	// start PDOx
	$db = new PDOx($config);
	
	
	// Example
	
	$records = $db->select('id, name, surname, age')->from('users')->where('age', '>', 18)->orderBy('id', 'desc')->limit(20)->getAll();
	
	foreach($records as $record) {
	
		echo $record->id . ' - ' . $record->name . ' ' . $record->surname . ' / ' . $record->age . '<br />';
	
	}

[![PDOx][pdox-img]][doc-url]

## PDOx
Hızlı, düzenli ve kullanışlı PDO Sınıfı #PHP


## Metot Listesi
```php
select
from
where
orWhere
whereIn
whereNotIn
join
leftJoin
rightJoin
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

## Örnek
```php

include('pdox.class.php');

$config = array(
	'user'		=> 'root',
	'pass'		=> '',
	'dbname'	=> 'test',
	'host'		=> 'localhost',
	'type'		=> 'mysql',
	'charset'	=> 'utf8'
);


$db = new PDOx($config);

$records = $db->
	select('id, name, surname, age')->
	from('users')->
	where('age', '>', 18)->
	orderBy('id', 'desc')->
	limit(20)->
	getAll();

foreach($records as $record) {

	echo $record->id . ' - ' . $record->name . ' / ' . $record->age . '<br />';

}
```
## Kullanım 
PDOx kullanımı ile ilgili döküman sayfasına [buradan][doc-url] ulaşabilirsiniz.

## Lisans
Açık kaynaklı olan bu proje [MIT lisansı][mit-url] ile lisanslanmıştır.

[pdox-img]: http://burakdemirtas.org/uploads/images/20140610210255_pdox_pdo_class_for_php.jpg
[paypal-donate-url]: http://burakdemirtas.org
[mit-url]: http://opensource.org/licenses/MIT
[doc-url]: http://burakdemirtas.org/pdox-kullanisli-pdo-sinifi-php/

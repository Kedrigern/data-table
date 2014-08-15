#Data table

For robust manipulation with table organized collection of data (excel, csv tables).

Provide ability to work with whole rows and columns, call callbacks, resort, rename, filter... See examples.

Import csv and array. Export to plain array, text, html, csv.

##Install

The best way how to install is use [Composer](https://getcomposer.org/):
```
php composer.phar require kedrigern/data-table
```

##Examples

Suppose:
```php
$table = new \Kedrigern\DataTable\RecordTable();
```

```php
$table->loadFromArray(array(
	array("Name", "Surname", "Age"),
	array("Jane", "Roe", 29),
	array("John", "Doe", 30)
));
$table->useFirstRowAsHeader();

// Sum the ages = 59
$ageSum = $table->colSum("Age");

$table->sortByCol("Surname");
$table->callToCol("Surname", 'strtoupper');

$newCol = range(1,$table->getRowsNum());
$table->appendCol($newCol, "Unique");

$newTable = $table->resortColsByNewHeader(array("Unique", "Surname", "Name"));
```

`$newTable` contains:
```
1 DOE John
2 ROE Jane
```
### CSV with header

Very common issue when you have some data in csv with header and you need only subset:
```php
$table->loadFromCsvFile(__DIR__ . '/../data/data4.csv');
$table->useFirstRowAsHeader();

$map = array(
	"Alpha" => "A",
	"Beta" => "B",
);

$table2 = $table->renameColumns($map);
```

Where `table2` contains column `Alpha` renamed to `A` and column `Beta` renamed to `B`. See [test](test/examples/readme2.phpt).

### Remove if

Remove all rows with even number in first column:
```php
$isEven = function($row) {
  return ($row[0] % 2) == 0;
};

$removed = $t->removeRowsIf($isEven);
```

In `removed` are number of modified rows.

### Parse datetime

```php
$table->loadFromArray(array(
	array("Name", "Surname", "Age", "Born", "Registered"),
	array("Jane", "Roe", 29, "1990-1-1", "2013-12-30 01:02:03"),
	array("John", "Doe", 30, "1990-1-1", "2014-12-30 01:02:03")
));
$table->useFirstRowAsHeader();

$func = array('\Kedrigern\DataTable\Callback','toDatetime');
$table->callToCol(3, $func, array('Y-m-d', 'M y'));

$func = array('\Kedrigern\DataTable\Callback','toDatetime');
$table->callToCol(4, $func, array('Y-m-d H:i:s', 'U', 'Europe/London'));
```

Now `Born` seems: `["Jan 90", "Feb 91"]`, and registered: `["1388361723", "1419897723"]`

### Join and split columns

```php
$table->loadFromArray(array(
	array("Name", "Surname"),
	array("Jane", "Roe"),
	array("John", "Doe")
));

$table->joinCols(array("Name", Surname", "Fullname");
```

In Fullname column you get: `["Jane Roe", "John Doe"]`.

Or opposite way:

```php
$table->loadFromArray(array(
	array("Fullname"),
	array("Jane Roe"),
	array("John Doe")
));

$table->splitCol("Fullname", array("Name", Surname");
```

##Author and contact
 * [Ondřej Profant](https://github.com/Kedrigern), 2014
 * [issues](https://github.com/Kedrigern/data-table/issues)



#Data table

For manipulation with table organized collection of data.

Provide ability to work with whole rows and columns. See examples.

Import csv, export to plain text, html, csv.

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

Or very common issue when you have some data in csv with header and you need only subset:
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

##Author and contact
 * [Ondřej Profant](https://github.com/Kedrigern), 2014
 * [issues](https://github.com/Kedrigern/data-table/issues)



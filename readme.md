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

```php
$table = new \Kedrigern\DataTable\RecordTable();
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

##Author and contact
 * [Ondřej Profant](https://github.com/Kedrigern), 2014
 * [issues](https://github.com/Kedrigern/data-table/issues)



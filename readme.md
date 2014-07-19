#Data table

For manipulation with table organized collection of data.

Provide ability to work with rows and columns. See examples.

Import csv, export to plain text, html, csv.

##Install

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

$table->sortBy("Surname");

$newCol = range(1,$table->getRowsNum());
$table->appendCol($newCol, "Unique");

$newTable = $table->resortColsByNewHeader(array("Unique", "Surname", "Name"));
```

`$newTable` contains:
```
1 Doe John
2 Roe Jane
```

##Author
Ondřej Profant


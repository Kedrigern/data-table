<?php

/**
 * Test: readme example
 */

require_once "../bootstrap.php";

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

\Tester\Assert::same(59, $ageSum);
\Tester\Assert::same(1, $newTable->get(0,0));
\Tester\Assert::same("DOE", $newTable->get(0,1));
\Tester\Assert::same("John", $newTable->get(0,2));
\Tester\Assert::same(2, $newTable->get(1,0));
\Tester\Assert::same("ROE", $newTable->get(1,1));
\Tester\Assert::same("Jane", $newTable->get(1,2));
\Tester\Assert::same(array("Unique", "Surname", "Name"), $newTable->getHeader());
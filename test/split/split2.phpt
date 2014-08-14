<?php

/**
 * Test: split
 */

require_once "../bootstrap.php";

$table = new \Kedrigern\DataTable\RecordTable();
$table->loadFromArray(array(
	array("Fullname"),
	array("Jane Roe"),
	array("John Doe")
));
$table->useFirstRowAsHeader();

\Tester\Assert::same(1,$table->getColsNum());

$table->splitCol("Fullname", array("Name","Surname"));

\Tester\Assert::same(3,$table->getColsNum());

$name = array("Jane", "John");
$surname = array("Roe", "Doe");
\Tester\Assert::same($name, $table->getColByName("Name"));
\Tester\Assert::same($surname, $table->getColByName("Surname"));
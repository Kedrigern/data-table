<?php

/**
 * Test: join
 */

require_once "../bootstrap.php";

$table = new \Kedrigern\DataTable\RecordTable();
$table->loadFromArray(array(
	array("Name", "Surname", "Age"),
	array("Jane", "Roe", 29),
	array("John", "Doe", 30)
));
$table->useFirstRowAsHeader();

$func = array('\Kedrigern\DataTable\Callback', 'defaultJoin');
\Tester\Assert::true(is_callable($func));

\Tester\Assert::same(3,$table->getColsNum());

$table->joinCols(array("Name","Surname"), "Fullname", $func);

\Tester\Assert::same(4,$table->getColsNum());

$fullname = array("Jane Roe", "John Doe");
\Tester\Assert::same($fullname, $table->getColByName("Fullname"));
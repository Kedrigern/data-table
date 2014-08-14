<?php

/**
 * Test: readme example to date function
 */

require_once "../bootstrap.php";

$table = new \Kedrigern\DataTable\RecordTable();
$table->loadFromArray(array(
	array("Name", "Surname", "Age", "Born", "Registered"),
	array("Jane", "Roe", 29, "1990-1-1", "2013-12-30 01:02:03"),
	array("John", "Doe", 30, "1991-2-1", "2014-12-30 01:02:03")
));
$table->useFirstRowAsHeader();

\Tester\Assert::same(5, $table->getColsNum());

$func = array('\Kedrigern\DataTable\Callback','toDatetime');
$table->callToCol("Born", $func, array('Y-m-d', 'M y'));

$func = array('\Kedrigern\DataTable\Callback','toDatetime');
$table->callToCol("Registered", $func, array('Y-m-d H:i:s', 'U', 'Europe/London'));

\Tester\Assert::same(5, $table->getColsNum());

\Tester\Assert::same("Jan 90", $table->get(0,3));
\Tester\Assert::same("Feb 91", $table->get(1,3));

\Tester\Assert::same("1388361723", $table->get(0,4));
\Tester\Assert::same("1419897723", $table->get(1,4));

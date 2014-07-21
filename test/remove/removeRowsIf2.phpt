<?php

/**
 * Test: remove rows by condition
 */

require_once "../bootstrap.php";

$data = array(
	array("hello"),
);

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray($data);

\Tester\Assert::same(1, $t->getRowsNum());

$removed = $t->removeRowsIf(function($row) {
	// remove all rows with even in first col
	return $row[0] == "hello";
});


\Tester\Assert::same(1, $removed);
\Tester\Assert::true($t->isEmpty());
\Tester\Assert::same(0, $t->getRowsNum());
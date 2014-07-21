<?php

/**
 * Test: remove row by number
 */

require_once "../bootstrap.php";

$data = array(
	array("a1", "a2"),
);

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray($data);

\Tester\Assert::same(1, $t->getRowsNum());

$t->removeRow(0);

\Tester\Assert::true($t->isEmpty());
\Tester\Assert::same(0, $t->getRowsNum());

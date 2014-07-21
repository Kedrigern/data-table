<?php

/**
 * Test: remove row by number
 */

require_once "../bootstrap.php";

$data = array(
	array("a1", "a2"),
	array("b1", "b2")
);

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray($data);

\Tester\Assert::same(2, $t->getRowsNum());

$t->removeRow(0);

\Tester\Assert::same(1, $t->getRowsNum());
\Tester\Assert::same("b1", $t->get(0,0));
\Tester\Assert::same("b2", $t->get(0,1));
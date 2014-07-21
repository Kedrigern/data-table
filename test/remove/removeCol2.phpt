<?php

/**
 * Test: remove row by number, empty result
 */

require_once "../bootstrap.php";

$data = array(
	array("a1"),
	array("b1")
);

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray($data);


$t->removeCol(0);

\Tester\Assert::true($t->isEmpty());
\Tester\Assert::same(0, $t->getColsNum());
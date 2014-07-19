<?php

require_once "../bootstrap.php";

$data = array(
	array("a1", "a2"),
	array("b1", "b2")
);

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray($data);

\Tester\Assert::same(false, $t->isEmpty());
\Tester\Assert::same(2, $t->getRowsNum());
\Tester\Assert::same(2, $t->getColsNum());

$t2 = new \Kedrigern\DataTable\RecordTable();

$t2->loadFromArray($data);

\Tester\Assert::same(false, $t2->isEmpty());
\Tester\Assert::same(2, $t2->getRowsNum());
\Tester\Assert::same(2, $t2->getColsNum());

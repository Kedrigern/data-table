<?php

require_once "../bootstrap.php";

$t1 = new \Kedrigern\DataTable\Table();
$t1->loadFromArray([
	['a1','a2'],
	['b1','b2'],
	[''],
	['c1','c2']
]);
$t1->removeEmpty(false);

\Tester\Assert::same($t1->getRowsNum(), 3);
\Tester\Assert::same($t1->getColsNum(), 2);
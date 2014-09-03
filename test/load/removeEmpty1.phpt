<?php

require_once "../bootstrap.php";

$t1 = new \Kedrigern\DataTable\Table();
$t1->loadFromArray([
	['a1','a2'],
	['b1','b2'],
	['']
], true);

\Tester\Assert::same($t1->getRowsNum(), 2);
\Tester\Assert::same($t1->getColsNum(), 2);
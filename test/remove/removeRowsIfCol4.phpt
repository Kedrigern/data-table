<?php

/**
 * Test: remove rows by condition
 */

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable;
$t->setHeader(['prvni', 'druhy']);
$t->loadFromArray( [
	["I",  1 ],
	["II", 2 ],
	["II",'2'],
	["III",3 ]
]);

\Tester\Assert::same(4, $t->getRowsNum());

$removed = $t->removeRowsIfCol(['\Kedrigern\DataTable\Callback', 'disallowValues'], 'druhy', [2,4]);

\Tester\Assert::same(2, $removed);
\Tester\Assert::same(2, $t->getRowsNum());
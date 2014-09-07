<?php

/**
 * Test: remove rows by condition
 */

require_once "../bootstrap.php";

$data = [
	["I",1],
	["II",2],
	["III",3]
];
$t = new \Kedrigern\DataTable\RecordTable;
$t->setHeader(['prvni', "druhy"]);
$t->loadFromArray($data);

\Tester\Assert::same(3, $t->getRowsNum());

$removed = $t->removeRowsIfCol(['\Kedrigern\DataTable\Callback', 'disallowValues'], "druhy", [2]);

\Tester\Assert::same(1, $removed);
\Tester\Assert::same(2, $t->getRowsNum());
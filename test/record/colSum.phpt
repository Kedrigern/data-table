<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();
$t->setHeader(array("a"));
$t->loadFromArray(array(
	array(1),
	array(2),
));

Tester\Assert::same(3, $t->colSum("a"));
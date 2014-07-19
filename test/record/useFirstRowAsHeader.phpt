<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();
$t->loadFromArray(array(
	array("a", "b", "c"),
	array( 1,  1,  1),
	array( 2,  2,  2),
));
$t->useFirstRowAsHeader();

Tester\Assert::same(1, $t->get(0,0));
Tester\Assert::same(2, $t->get(1,0));

Tester\Assert::same(array("a", "b", "c"), $t->getHeader());
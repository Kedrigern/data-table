<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();
$t->setHeader(array("a", "b", "c"));
$t->loadFromArray(array(
	array( "a",  "b",  "c")
));

$t2 = $t->resortColsByNewHeader(array("c", "b", "a"));

\Tester\Assert::same("c", $t2->get(0,0));
\Tester\Assert::same("b", $t2->get(0,1));
\Tester\Assert::same("a", $t2->get(0,2));
\Tester\Assert::same(array("c","b","a"), $t2->getRow(0));
\Tester\Assert::same(array("c","b","a"), $t2->getHeader());
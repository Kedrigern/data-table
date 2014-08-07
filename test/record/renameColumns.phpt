<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();
$t->setHeader(array("a", "b", "c"));
$t->loadFromArray(array(
	array( "a1",  "b1",  "c1"),
	array( "a2",  "b2",  "c2")
));

$map = array(
	"b" => "Beta",
	"a" => "Alpha",
);

$t2 = $t->renameColumns($map);

\Tester\Assert::same("b1", $t2->get(0,0));
\Tester\Assert::same("a1", $t2->get(0,1));
\Tester\Assert::same("b2", $t2->get(1,0));
\Tester\Assert::same("a2", $t2->get(1,1));

\Tester\Assert::same(array("b1","b2"), $t2->getCol(0));
\Tester\Assert::same(array("Beta","Alpha"), $t2->getHeader());
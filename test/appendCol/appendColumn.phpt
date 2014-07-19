<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray(array(
	array("a1", "a2"),
	array("b1", "b2")
));

$t->appendCol(array("a3", "b3"));

\Tester\Assert::same(array("a1", "b1"), $t->getCol(0));
\Tester\Assert::same(array("a2", "b2"), $t->getCol(1));
\Tester\Assert::same(array("a3", "b3"), $t->getCol(2));

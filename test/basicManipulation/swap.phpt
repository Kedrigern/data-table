<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray(array(
	array("a1", "a2"),
	array("b1", "b2"),
));

$t->swapCol(0,1);

\Tester\Assert::same("a2", $t->get(0,0));
\Tester\Assert::same("a1", $t->get(0,1));
\Tester\Assert::same("b2", $t->get(1,0));
\Tester\Assert::same("b1", $t->get(1,1));

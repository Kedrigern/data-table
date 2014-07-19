<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();

$t->loadFromArray(array(
	/*     0    1    2    3   4   5  */
	array("a", "b", "1", "2", 1, 3.14),
	array("b", "a", "2", "1", 2, 2.71)
));

$t->sortBy(0);

\Tester\Assert::same("a", $t->get(0,0));

echo($t->toString());

$t->sortBy(1);

echo($t->toString());
\Tester\Assert::same("b", $t->get(0,0));

$t->sortBy(2);

\Tester\Assert::same("a", $t->get(0,0));

$t->sortBy(3);

\Tester\Assert::same("b", $t->get(0,0));

$t->sortBy(4);

\Tester\Assert::same("a", $t->get(0,0));

$t->sortBy(5);

\Tester\Assert::same("b", $t->get(0,0));
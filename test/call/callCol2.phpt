<?php

/**
 * Test: callToCol, php function
 */

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray(array(
	array("a"),
	array("b"),
	array("c")
));

$t->callToCol(0, 'strtoupper');

\Tester\Assert::same("A", $t->get(0,0));
\Tester\Assert::same("B", $t->get(1,0));
\Tester\Assert::same("C", $t->get(2,0));
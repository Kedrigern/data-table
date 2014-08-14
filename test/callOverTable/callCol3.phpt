<?php

/**
 * Test: callToCol by name
 */

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();
$t->setHeader(array("C"));
$t->loadFromArray(array(
	array("a"),
	array("b"),
	array("c")
));

$t->callToCol("C", 'strtoupper');

\Tester\Assert::same("A", $t->get(0,0));
\Tester\Assert::same("B", $t->get(1,0));
\Tester\Assert::same("C", $t->get(2,0));
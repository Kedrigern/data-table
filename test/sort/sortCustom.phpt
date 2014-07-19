<?php

/**
 * Test: custom sort test
 */

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();

$t->loadFromArray(array(
	array("a"),
	array("b"),
	array("c")
));

// Descending c b a
$t->sortBy(0, function($a, $b) {
	if ($a[0] == $b[0]) {
		return 0;
	}
	return ($a[0] > $b[0]) ? -1 : 1;
});
\Tester\Assert::same("c", $t->get(0,0));
\Tester\Assert::same("b", $t->get(1,0));
\Tester\Assert::same("a", $t->get(2,0));

// Ascending a b c
$t->sortBy(0, function($a, $b) {
	if ($a[0] == $b[0]) {
		return 0;
	}
	return ($a[0] < $b[0]) ? -1 : 1;
});
\Tester\Assert::same("a", $t->get(0,0));
\Tester\Assert::same("b", $t->get(1,0));
\Tester\Assert::same("c", $t->get(2,0));

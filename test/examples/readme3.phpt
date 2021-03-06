<?php

/**
 * Test: remove rows by condition
 */

require_once "../bootstrap.php";

$data = array(
	array(1),
	array(2),
	array(3),
	array(4),
);

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray($data);

\Tester\Assert::same(4, $t->getRowsNum());

$isEven = function($row) {
	// remove all rows with even in first col
	return ($row[0] % 2) == 0;
};

\Tester\Assert::same(false, call_user_func($isEven, array(1)));
\Tester\Assert::same(true, call_user_func($isEven, array(2)));
\Tester\Assert::same(false, call_user_func($isEven, array(3)));
\Tester\Assert::same(true, call_user_func($isEven, array(4)));

$removed = $t->removeRowsIf($isEven);

\Tester\Assert::same(2, $removed);
\Tester\Assert::same(2, $removed);
\Tester\Assert::same(2, $t->getRowsNum());
\Tester\Assert::same(1, $t->get(0,0));
\Tester\Assert::same(3, $t->get(1,0));
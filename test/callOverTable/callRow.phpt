<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();

$t->loadFromArray(array(
	array(1, 1),
	array(1, 1),
));

$t->callToRow(0, function($cell) {
	return $cell+1;
});

\Tester\Assert::same(2, $t->get(0,0));
\Tester\Assert::same(2, $t->get(0,1));

\Tester\Assert::same(1, $t->get(1,0));
\Tester\Assert::same(1, $t->get(1,1));

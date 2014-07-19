<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();

$t->loadFromArray(array(
	array(1),
	array(1),
	array(1)
));

$t->callToCol(0, function($cell) {
	return $cell+1;
});

\Tester\Assert::same(2, $t->get(0,0));
\Tester\Assert::same(2, $t->get(1,0));
\Tester\Assert::same(2, $t->get(2,0));


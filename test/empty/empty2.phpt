<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\Table();
$t->loadFromArray(array(
	array(),
	array("hello"),
));

\Tester\Assert::true($t->isRowEmpty(0));
\Tester\Assert::false($t->isRowEmpty(1));
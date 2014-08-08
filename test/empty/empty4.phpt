<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\Table();
$t->loadFromArray(array(
	array("","hello"),
	array(0,1),
));

\Tester\Assert::true($t->isColEmpty(0));
\Tester\Assert::false($t->isColEmpty(1));
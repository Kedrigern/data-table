<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();
$t->setHeader(array("Fullname"));
$t->loadFromArray(array(
	array( "John Doe"),
	array( "Jane Roe")
));

$map = array(
	array('split', "Fullname", array("Name", "Surname"))
);

$t2 = $t->renameColumns($map);

\Tester\Assert::same("John", $t2->get(0,0));
\Tester\Assert::same("Doe", $t2->get(0,1));
\Tester\Assert::same("Jane", $t2->get(1,0));
\Tester\Assert::same("Roe", $t2->get(1,1));

\Tester\Assert::same(array("Name", "Surname"), $t2->getHeader());
<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();
$t->loadFromCsvFile(__DIR__ . '/../data/data4.csv');
$t->useFirstRowAsHeader();

$map = array(
	"Alpha" => "A",
	"Beta" => "B",
);

$t2 = $t->renameColumns($map);

\Tester\Assert::same(array("A","B"), $t2->getHeader());


\Tester\Assert::same("a1", $t2->get(0,0));
\Tester\Assert::same("b1", $t2->get(0,1));
\Tester\Assert::same("a2", $t2->get(1,0));
\Tester\Assert::same("b2", $t2->get(1,1));


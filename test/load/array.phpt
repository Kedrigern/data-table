<?php

require_once "../bootstrap.php";

$t1 = new \Kedrigern\DataTable\Table();
$t1->loadFromCsvFile("../data/data1.csv", 5000,';');

\Tester\Assert::same("a1", $t1->get(0,0));
\Tester\Assert::same("a2", $t1->get(0,1));
\Tester\Assert::same("b1", $t1->get(1,0));
\Tester\Assert::same("b2", $t1->get(1,1));

$t2 = new \Kedrigern\DataTable\Table();
$t2->loadFromCsvFile("../data/data2.csv");

\Tester\Assert::same("a1", $t2->get(0,0));
\Tester\Assert::same("a2", $t2->get(0,1));
\Tester\Assert::same("b1", $t2->get(1,0));
\Tester\Assert::same("b2", $t2->get(1,1));

$t2->swapCol(0,1);

\Tester\Assert::same("a2", $t2->get(0,0));
\Tester\Assert::same("a1", $t2->get(0,1));
\Tester\Assert::same("b2", $t2->get(1,0));
\Tester\Assert::same("b1", $t2->get(1,1));

$t3 = new \Kedrigern\DataTable\Table();
$t3->loadFromCsvString("a1,a2\n
b1,b2");

\Tester\Assert::same("a1", $t3->get(0,0));
\Tester\Assert::same("a2", $t3->get(0,1));
\Tester\Assert::same("b1", $t3->get(1,0));
\Tester\Assert::same("b2", $t3->get(1,1));
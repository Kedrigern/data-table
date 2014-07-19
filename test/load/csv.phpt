<?php

require_once "../bootstrap.php";

$t1 = new \Kedrigern\DataTable\Table();
$t1->loadFromCsvFile("../data/data1.csv", 5000,';');

\Tester\Assert::Same("a1",$t1->get(0,0));
\Tester\Assert::Same("a2",$t1->get(0,1));
\Tester\Assert::Same("b1",$t1->get(1,0));
\Tester\Assert::Same("b2",$t1->get(1,1));

$t2 = new \Kedrigern\DataTable\Table();
$t2->loadFromCsvFile("../data/data2.csv");

\Tester\Assert::Same("a1",$t1->get(0,0));
\Tester\Assert::Same("a2",$t1->get(0,1));
\Tester\Assert::Same("b1",$t1->get(1,0));
\Tester\Assert::Same("b2",$t1->get(1,1));

$t3 = new \Kedrigern\DataTable\Table();
$t3->loadFromCsvString("a1,a2\n
b1,b2");

\Tester\Assert::Same("a1",$t1->get(0,0));
\Tester\Assert::Same("a2",$t1->get(0,1));
\Tester\Assert::Same("b1",$t1->get(1,0));
\Tester\Assert::Same("b2",$t1->get(1,1));
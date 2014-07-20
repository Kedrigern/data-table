<?php

/**
 * Test: csv escaped sequence
 */

require_once "../bootstrap.php";

$t1 = new \Kedrigern\DataTable\Table();
$t1->loadFromCsvFile("../data/data3.csv", 5000, ',', '"', "\\");

\Tester\Assert::Same("abc", $t1->get(0,0));
//\Tester\Assert::Same('abc"cba', $t1->get(0,1));
\Tester\Assert::Same("abc'cba",  $t1->get(0,2));




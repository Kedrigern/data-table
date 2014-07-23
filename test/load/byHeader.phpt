<?php

require_once "../bootstrap.php";

$data = array(
	array("Fruit" => "Apple", "Vegetable" => "Carrot"),
	array("Vegetable" => "Cucumber", "Fruit" => "Orange", "Foo" => "Bar"),
);

$t1 = new \Kedrigern\DataTable\RecordTable();
$t1->setHeader(array("Fruit", "Vegetable"));
$t1->loadByHeader($data);

\Tester\Assert::same("Apple", $t1->get(0,0));
\Tester\Assert::same("Carrot", $t1->get(0,1));
\Tester\Assert::same("Orange", $t1->get(1,0));
\Tester\Assert::same("Cucumber", $t1->get(1,1));
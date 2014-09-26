<?php

require_once "../bootstrap.php";

$t1 = new \Kedrigern\DataTable\Table();
$t1->loadFromArray([], true);

\Tester\Assert::true($t1->isEmpty());

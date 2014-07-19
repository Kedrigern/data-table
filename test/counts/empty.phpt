<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\Table();

\Tester\Assert::same(true, $t->isEmpty());
\Tester\Assert::same(0, $t->getRowsNum());
\Tester\Assert::same(0, $t->getColsNum());

$t = new \Kedrigern\DataTable\RecordTable();

\Tester\Assert::same(true, $t->isEmpty());
\Tester\Assert::same(0, $t->getRowsNum());
\Tester\Assert::same(0, $t->getColsNum());

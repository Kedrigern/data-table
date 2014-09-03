<?php

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\RecordTable();
$t->setHeader(["a", "b", "c"]);

Tester\Assert::same(["a", "b", "c"], $t->getHeader());

$t->setHeader([" a", " b ", "c "]);
$t->trimHeader();

Tester\Assert::same(["a", "b", "c"], $t->getHeader());

$t->setHeader(["a", "   b   ", "c   "]);
$t->trimHeader();

Tester\Assert::same(["a", "b", "c"], $t->getHeader());

$t->setHeader(["﻿a", "b", "c"]);
$t->trimHeader();

Tester\Assert::same(["a", "b", "c"], $t->getHeader());
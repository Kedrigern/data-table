<?php

use Tester\Assert;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/load.php';

\Tester\Environment::setup();

date_default_timezone_set('Europe/Prague');

$dataArray = array(
	array("a1", "a2"),
	array("b1", "b2"),
);
<?php

/**
 * Callback default join
 */

require_once "../bootstrap.php";

$joined = Kedrigern\DataTable\Callback::defaultJoin(array("Hello", "world", "!"));

\Tester\Assert::same("Hello world !", $joined);
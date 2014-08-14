<?php

/**
 * Test: call to call with params
 */

require_once "../bootstrap.php";

$t = new \Kedrigern\DataTable\Table();

$t->loadFromArray(array(
	array('1. 1. 2014 00:30'),
	array('1. 2. 2014 08:30'),
	array('1. 3. 2014 12:30'),
	array('1. 4. 2014 15:45'),
	array('10. 5. 2014 15:45')
));

$t->callToCol(0, array('\Kedrigern\DataTable\Callback','toDatetime'), array('d. m. Y H:i', 'Y-m-d H:i:s'));

\Tester\Assert::same('2014-01-01 00:30:00', $t->get(0,0));
\Tester\Assert::same('2014-02-01 08:30:00', $t->get(1,0));
\Tester\Assert::same('2014-03-01 12:30:00', $t->get(2,0));
\Tester\Assert::same('2014-04-01 15:45:00', $t->get(3,0));
\Tester\Assert::same('2014-05-10 15:45:00', $t->get(4,0));
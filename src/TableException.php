<?php namespace Kedrigern\DataTable;

class TableException extends \Exception {}

abstract class UnknownCol extends TableException
{
	/** @var string */
	public $name;

	/** @var string */
	public $val;

	/**
	 * @param string $message
	 * @param int $code
	 * @param \Exception $previous
	 * @param string $name
	 * @param string $val
	 */
	public function __construct($message = '', $code = 0, \Exception $previous = null, $name = "?", $val = "") {
		parent::__construct($message, $code, $previous);
		$this->name = $name;
		$this->val = $val;
	}
}

final class UnknownColName extends UnknownCol {}

final class UnknownColFormat extends UnknownCol {}

class InvalidCallback extends TableException {}
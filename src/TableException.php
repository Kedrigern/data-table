<?php namespace Kedrigern\DataTable;

class TableException extends \Exception {}

class UnknownColName extends TableException
{
	/** @var string */
	public $name;

	/**
	 * @param string $message
	 * @param int $code
	 * @param \Exception $previous
	 * @param string $name
	 */
	public function __construct($message = '', $code = 0, \Exception $previous = null, $name = "?") {
		parent::__construct($message, $code, $previous);
		$this->name = $name;
	}
}

class InvalidCallback extends TableException
{

}
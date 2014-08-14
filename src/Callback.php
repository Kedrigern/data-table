<?php namespace Kedrigern\DataTable;

class Callback {

	/**
	 * Join columns with space
	 * @param $cols
	 * @return string
	 */
	public static function defaultJoin($cols)
	{
		$joined = "";
		foreach($cols as $col) {
			$joined .= $col . " ";
		}
		$joined = substr($joined, 0, mb_strlen($joined)-1);
		return $joined;
	}

	/**
	 * Split column by " "
	 * @param string $content
	 * @return array
	 */
	public static function defaultSplit($content) {
		return explode(" ", $content);
	}

	/**
	 * @param string $cell
	 * @param array $params
	 * @return string
	 */
	public static function toDatetime($cell, $params) {
		$dt = \DateTime::createFromFormat($params[0], $cell);
		if(isset($params[2])) {
			$dt->setTimezone(new \DateTimeZone($params[2]));
		}
		return $dt->format($params[1]);
	}
}
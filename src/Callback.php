<?php namespace Kedrigern\DataTable;

class Callback {

	/**
	 * Join columns with space
	 * @param array $cols
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
	 * @param array $cols
	 * @param array $params
	 * @return string
	 */
	public static function joinWith($cols, $params)
	{
		$joined = "";
		foreach($cols as $col) {
			$joined .= $col . $params[0];
		}
		$joined = substr($joined, 0, mb_strlen($joined)-mb_strlen($params[0]));
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
	 * @throws UnknownColFormat
	 */
	public static function toDatetime($cell, $params) {
		$dt = \DateTime::createFromFormat($params[0], $cell);
		if($dt === false) {
			throw new UnknownColFormat('', 0, null, 'date', $cell);
		}
		if(isset($params[2])) {
			$dt->setTimezone(new \DateTimeZone($params[2]));
		}
		return $dt->format($params[1]);
	}

	/**
	 * @param string|int $cell
	 * @return bool
	 */
	public static function isEven($cell) {
		return intval($cell) % 2 == 0;
	}

	/**
	 * @param string|int $cell
	 * @return bool
	 */
	public static function isOdd($cell) {
		return !self::isEven($cell);
	}

	/**
	 * @param string $cell
	 * @param array $values
	 * @return bool
	 */
	public static function allowValues($cell, array $values) {
		return !in_array($cell, $values);
	}

	/**
	 * @param string $cell
	 * @param array $values
	 * @return bool
	 */
	public static function disallowValues($cell, array $values) {
		return in_array($cell, $values);
	}

	/**
	 * Trim unicode string
	 * @param string $str
	 * @return string
	 */
	public static function unicodeTrim ($str) {
		return preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', $str);
	}
}
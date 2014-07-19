<?php namespace Kedrigern\DataTable;

/**
 * Class Table basic implementation of ITable
 *
 * @author Ondřej Profant
 */
class Table implements ITable {

	/** @var array */
	protected $table = array();

	/** @var int */
	public $sortNum = 0;

	/**** Getters ****/

	/**
	 * @inheritdoc
	 */
	public function get($i, $j)
	{
		return $this->table[$i][$j];
	}

	/**
	 * @inheritdoc
	 */
	public function getCol($num)
	{
		return array_column($this->table, $num);
	}

	/**
	 * @inheritdoc
	 */
	public function getRow($num)
	{
		return $this->table[$num];
	}


	/**
	 * @inheritdoc
	 */
	public function getColsNum()
	{
		if(isset($this->table[0])) {
			return count($this->table[0]);
		}
		return 0;
	}

	/**
	 * @inheritdoc
	 */
	public function getRowsNum()
	{
		return count($this->table);
	}

	/**
	 * @inheritdoc
	 */
	public function isEmpty() {
		return empty($this->table);
	}

	/**** Loads ****/

	/**
	 * @inheritdoc
	 */
	public function loadFromArray(array $rawArray) {
		$this->table = $rawArray;
	}

	/**
	 * @inheritdoc
	 */
	public function loadFromCsvString($text, $delimiter = ",", $enclosure = '"', $escape = "\\")
	{
		$this->table = array();
		$lines = array_filter(explode("\n", $text));
		foreach($lines as $line) {
			$this->table[] = str_getcsv($line, $delimiter, $enclosure, $escape);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function loadFromCsvFile($filename, $length = 5000, $delimiter = ",", $enclosure = '"', $escape = "\\")
	{
		$this->table = array();
		$handle = fopen($filename, 'r');
		while(($data = fgetcsv($handle, $length, $delimiter, $enclosure, $escape)) !== FALSE) {
			$this->table[] = $data;
		}
		fclose($handle);
	}

	/**** Modification ****/

	/**
	 * @inheritdoc
	 */
	public function swapCol($col1, $col2)
	{
		$tmpCol1 = $this->getCol($col1);
		$tmpCol2 = $this->getCol($col2);

		foreach($this->table as $index => &$row) {
			$row[$col1] = $tmpCol2[$index];
			$row[$col2] = $tmpCol1[$index];
		}
	}

	/**
	 * @inheritdoc
	 */
	public function swapRow($row1, $row2)
	{
		$tmpRow = $this->table[$row1];
		$this->table[$row1] = $this->table[$row2];
		$this->table[$row2] = $tmpRow;
	}

	/**
	 * @inheritdoc
	 */
	public function sortBy($num, $compare = null)
	{
		$this->sortNum = $num;
		if(is_null($compare)) $compare = array($this, 'naturalSort');
		usort($this->table, $compare);
	}

	/**
	 * @inheritdoc
	 */
	public function callToCol($num, $function)
	{
		foreach($this->table as &$row) {
			$row[$num] = call_user_func($function, $row[$num]);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function callToRow($num, $function)
	{
		foreach($this->table[$num] as &$cell) {
			$cell = call_user_func($function, $cell);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function appendCol(array $col)
	{
		if(count($this->table) == 0) {
			foreach($col as $cell) {
				$this->table[] = array($cell);
			}
			return;
		}

		$index = 0;
		foreach($this->table as &$row) {
			$row[] = $col[$index];
			$index++;
		}
	}

	/**** Exports ****/

	/**
	 * @return array
	 */
	public function toArray() {
		return $this->table;
	}

	/**
	 * @inheritdoc
	 */
	public function toString($delimiter = "\t", $colSize = 0) {
		$string = "";
		foreach($this->table as $row) {
			foreach($row as $cell) {
				$string .= str_pad($cell, $colSize) . $delimiter;
			}
			$string .= "\n";
		}
		return $string;
	}

	/**
	 * @inheritdoc
	 */
	public function toHtml() {
		$string = '<table>';
		$string .= '<tbody>';
		foreach($this->table as $row) {
			$string .= '<tr>';
			foreach($row as $cell) {
				$string .= '<td>' . $cell . '</td>';
			}
			$string .= '</tr>';
		}
		$string .= '</tbody>';
		$string .= '</table>';
		return $string;
	}

	/**
	 * @inheritdoc
	 * @todo enclosure
	 */
	public function toCsv($delimiter = ",") {
		$string = '';
		foreach($this->table as $row) {
			foreach($row as $cell) {
				$string .= $cell . $delimiter;
			}
			$string .= "\n";
		}
		return $string;
	}

	/**** Internal ****/

	/**
	 * Natural sort for rows by column
	 * @param array $a
	 * @param array $b
	 * @return int
	 */
	protected function naturalSort($a, $b) {
		if ($a[$this->sortNum] == $b[$this->sortNum]) {
			return 0;
		}
		return ($a[$this->sortNum] < $b[$this->sortNum]) ? -1 : 1;
	}
}
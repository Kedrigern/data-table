<?php namespace Kedrigern\DataTable;

/**
 * Class Table basic implementation of ITable
 *
 * @author Ondřej Profant
 */
class Table implements ITable {

	/** @var array main data*/
	protected $table = array();

	/** @var int for sorting algorithm */
	public $sortNum = 0;

	/**** Getters ****/

	/**
	 * @param int $i
	 * @param int $j
	 * @return mixed
	 */
	public function get($i, $j)
	{
		return $this->table[$i][$j];
	}

	/**
	 * Get the column
	 * @param int $num
	 * @return array
	 */
	public function getCol($num)
	{
		return array_column($this->table, $num);
	}

	/**
	 * @param int $num
	 * @return array
	 */
	public function getRow($num)
	{
		return $this->table[$num];
	}


	/**
	 * Get total number of columns
	 * @return int
	 */
	public function getColsNum()
	{
		if(isset($this->table[0])) {
			return count($this->table[0]);
		}
		return 0;
	}

	/**
	 * Get total number of rows
	 * @return int
	 */
	public function getRowsNum()
	{
		return count($this->table);
	}

	/**
	 * @return bool
	 */
	public function isEmpty() {
		return empty($this->table);
	}

	/**** Loads ****/

	/**
	 * @param array $rawArray multidimensional array, format:
	 * <code>
	 *  array (
	 *      array("row1 col1", "row1 col2"),
	 *      array("row2 col1", "row2 col2"),
	 *  )
	 * </code>
	 */
	public function loadFromArray(array $rawArray) {
		$this->table = $rawArray;
	}

	/**
	 * Load from csv string
	 * @param string $text
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
	 * Load from csv file
	 * @param string $filename
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
	 * Swap two columns
	 * @param int $col1 number of column
	 * @param int $col2 number of column
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
	 * Swap two rows
	 * @param int $row1
	 * @param int $row2
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

	/**
	 * Remove given column
	 * @param int $num
	 */
	public function removeCol($num) {
		if($num == 0 && $this->getColsNum() == 1) {
			$this->table = array();
			return;
		}

		foreach($this->table as &$row) {
			unset($row[$num]);
			$row = array_values($row);
		}
	}

	/**
	 * Remove given row
	 * @param int $num
	 */
	public function removeRow($num) {
		unset($this->table[$num]);
		// normalize indexes
		$this->table = array_values($this->table);
	}

	/**
	 * @inheritdoc
	 */
	public function removeRowsIf($condition) {
		$modified = 0;

		foreach($this->table as $key => $row) {
			$ret = call_user_func($condition, $row);
			if($ret) {
				unset($this->table[$key]);
				$modified++;
			}
		}
		// normalize indexes
		$this->table = array_values($this->table);

		return $modified;
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
	 */
	public function toCsv($delimiter = ",") {
		$string = '';
		foreach($this->table as $row) {
			foreach($row as $cell) {
				if(is_numeric($cell)) {
					$string .= $cell;
				} else {
					$string .= addslashes($cell);
				}
				$string .= $delimiter;
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
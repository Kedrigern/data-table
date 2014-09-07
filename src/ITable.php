<?php namespace Kedrigern\DataTable;

/**
 * Interface ITable
 * Represents organized collection of data.
 * Via this structure is possible to easily modify the data in both way - as rows, as columns
 *
 * @author Ondřej Profant
 */
interface ITable {

	/**** Getters ****/

	/**
	 * @param int $i
	 * @param int $j
	 * @return mixed
	 */
	public function get($i, $j);

	/**
	 * Get the column
	 * @param int $num
	 * @return array
	 */
	public function getCol($num);

	/**
	 * Get total number of columns
	 * @return int
	 */
	public function getColsNum();

	/**
	 * @param int $num
	 * @return array
	 */
	public function getRow($num);

	/**
	 * Get total number of rows
	 * @return int
	 */
	public function getRowsNum();

	/**
	 * @return bool
	 */
	public function isEmpty();

	/**
	 * Check if every cell in row is empty (by the buildin empty function)
	 * Be careful 0 is valued as empty
	 * @param int $num
	 * @return bool
	 */
	public function isRowEmpty($num);

	/**
	 * Check if every cell in column is empty (by the buildin empty function)
	 * Be careful 0 is valued as empty
	 * @param int $num
	 * @return bool
	 */
	public function isColEmpty($num);

	/**** Modification ****/

	/**
	 * Sort the table by the column
	 * @param int $num
	 * @param callable|null $compare
	 */
	public function sortBy($num, $compare = null);

	/**
	 * Call function to the all values in the column
	 * @param int $num of column
	 * @param callable $function
	 * @param array $params params to the callback
	 * @throws InvalidCallback
	 */
	public function callToCol($num, $function, $params = null);

	/**
	 * Call function to the all values in the row
	 * @param int $num of row
	 * @param callable $function
	 * @param array $params params to the callback
	 * @throws InvalidCallback
	 */
	public function callToRow($num, $function, $params = null);

	/**
	 * Swap two columns
	 * @param int $col1 number of column
	 * @param int $col2 number of column
	 */
	public function swapCol($col1, $col2);

	/**
	 * Swap two rows
	 * @param int $row1
	 * @param int $row2
	 */
	public function swapRow($row1, $row2);

	/**
	 * Append new column to the table
	 * @param array $col
	 */
	public function appendCol(array $col);

	/**
	 * Remove given column
	 * @param int $num
	 */
	public function removeCol($num);

	/**
	 * Remove given row
	 * @param int $num
	 */
	public function removeRow($num);

	/**
	 * Remove rows if $callback return true
	 * @param callable $callback
	 * @param array $param
	 * @return int number of removed rows
	 */
	public function removeRowsIf($callback, $param = []);

	/**** Loads ****/

	/**
	 * @param array $rawArray multidimensional array, format:
	 * <code>
	 *  array (
	 *      array("row1 col1", "row1 col2"),
	 *      array("row2 col1", "row2 col2"),
	 *  )
	 * </code>
	 * @param bool $removeLastEmpty removes lines with another size than first
	 */
	public function loadFromArray(array $rawArray, $removeLastEmpty = false);

	/**
	 * Load from csv string
	 * @param string $text
	 */
	public function loadFromCsvString($text);

	/**
	 * Load from csv file
	 * @param string $filename
	 */
	public function loadFromCsvFile($filename);

	/**** Exports ****/

	/**
	 * Export as multidimensional array:
	 * <code>
	 *  array (
	 *      array("row1 col1", "row1 col2"),
	 *      array("row2 col1", "row2 col2"),
	 *  )
	 * </code>
	 * @return array
	 */
	public function toArray();

	/**
	 * Export as string
	 * @param string $delimiter
	 * @param int $colSize
	 * @return string
	 */
	public function toString($delimiter = "\t", $colSize = 0);

	/**
	 * Export as html table
	 * @return string in html table format
	 */
	public function toHtml();

	/**
	 * @param string $delimiter
	 * @return string
	 */
	public function toCsv($delimiter = ",");
} 
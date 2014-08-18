<?php namespace Kedrigern\DataTable;

/**
 * Interface IRecordTable
 *
 * @author Ondřej Profant
 */
interface IRecordTable extends ITable {

	/**
	 * @return array
	 */
	public function getHeader();

	/**
	 * @param array $header
	 */
	public function setHeader(array $header);

	/**
	 * Get row as associative array
	 * @param int $num
	 * @return array
	 */
	public function getRowAssoc($num);

	/**
	 *
	 * @return array
	 */
	public function getTableAssoc();

	/**
	 * @param string $name
	 * @return array
	 */
	public function getColByName($name);

	/**
	 * @param string|int $name or num of column
	 * @param callable $function
	 * @param array $params
	 */
	public function callToCol($name, $function, $params = null);

	/**
	 * @param string $name
	 * @param callable|null $compare
	 */
	public function sortByCol($name, $compare = null);

	/**
	 * @param string $oldName
	 * @param string $newName
	 */
	public function renameCol($oldName, $newName);

	/**
	 * @param string $name1
	 * @param string $name2
	 */
	public function swapColByNames($name1, $name2);

	/**
	 * Use first row as column
	 */
	public function useFirstRowAsHeader();

	/**
	 * @param sum $name
	 * @return int
	 */
	public function colSum($name);

	/**
	 * Join columns into one
	 * @param array $cols columns to be join
	 * @param string|int $col
	 * @param null|callable $callback
	 */
	public function joinCols(array $cols, $col, $callback = null);

	/**
	 * Split column into many
	 * @param string|int $col to be splited
	 * @param array $cols of new column names
	 * @param null|callable $callback
	 */
	public function splitCol($col, array $cols, $callback = null);

	/**
	 * Create new instance with subset of column in given order
	 * For example:
	 * <code>
	 *  $t->setHeader(array("a", "b", "c"));
	 *	$t->loadFromArray(array(
	 * 	    array( "a",  "b",  "c")
	 *  ));
	 *  $t2 = $t->resortColsByNewHeader(array("c", "b"));
	 * </code>
	 * @param array $newHeader
	 * @return RecordTable
	 */
	public function resortColsByNewHeader(array $newHeader);

	/**
	 * @param array $newHeader must be associative array with format:
	 * <code>
	 *      oldColName1 => newColName1,
	 *      array('join', array(oldA, oldB), newColName2),
	 *      array('split', oldColName3, array(newA, newB)),
	 *      oldColName4 => newColName4
	 *      ...
	 * </code>
	 * Order is hold by order in array
	 * @return RecordTable
	 */
	public function renameColumns(array $newHeader);

	/**
	 * Load from iterable data. For example some DB class, and load only columns from header.
	 * @param iterable $data
	 */
	public function loadByHeader($data);
}

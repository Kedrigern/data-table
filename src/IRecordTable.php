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
	 * @param array $newHeader
	 */
	public function resortColsByNewHeader(array $newHeader);
}

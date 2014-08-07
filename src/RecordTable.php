<?php namespace Kedrigern\DataTable;

/**
 * Class RecordTable
 *
 * @author Ondřej Profant
 */
class RecordTable extends Table implements IRecordTable {

	/** @var array */
	protected $header = array();

	/**
	 * @return array
	 */
	public function getHeader()
	{
		return $this->header;
	}

	/**
	 * @param array $header
	 */
	public function setHeader(array $header)
	{
		$this->header = $header;
	}

	/**
	 * @param string $name
	 * @return array
	 */
	public function getColByName($name)
	{
		$num = $this->findColNum($name);
		return $this->getCol($num);
	}

	/**
	 * @inheritdoc
	 */
	public function callToCol($name, $function) {
		if(!is_numeric($name)) {
			$name = $this->findColNum($name);
		}
		parent::callToCol($name, $function);
	}

	/**
	 * Get row as associative array
	 * @param int $num
	 * @return arrow
	 */
	public function getRowAssoc($num)
	{
		return array_combine($this->header, $this->table[$num]);
	}

	/**
	 *
	 * @return array
	 */
	public function getTableAssoc() {
		$table = array();
		for($i = 0; $i < $this->getRowsNum(); $i++) {
			$table[] = $this->getRowAssoc($i);
		}
		return $table;
	}

	/**
	 * Swap two columns
	 * @param int $col1
	 * @param int $col2
	 */
	public function swapCol($col1, $col2)
	{
		parent::swapCol($col1, $col2);
		$tmpC1 = $this->header[$col1];
		$this->header[$col1] = $this->header[$col2];
		$this->header[$col2] = $tmpC1;
	}

	/**
	 * @param string $oldName
	 * @param string $newName
	 */
	public function renameCol($oldName, $newName) {
		foreach($this->header as &$name) {
			if($name == $oldName) {
				$name = $newName;
				break;
			}
		}
	}

	/**
	 * Remove given column
	 * @param int $num
	 */
	public function removeCol($num) {
		parent::removeCol($num);
		unset($this->header[$num]);
		$this->header = array_values($this->header);
	}

	/**
	 * Use first row as column
	 */
	public function useFirstRowAsHeader() {
		$this->header = $this->table[0];
		unset($this->table[0]);
		$this->table =  array_values($this->table); // normalize indexes
	}

	/**
	 * @param string $name
	 * @param callable|null $compare
	 */
	public function sortByCol($name, $compare = null)
	{
		$num = $this->findColNum($name);
		$this->sortBy($num, $compare);
	}

	/**
	 * @param string $name
	 * @return int
	 */
	public function colSum($name)
	{
		$num = $this->findColNum($name);
		$sum = 0;
		foreach($this->table as $row) {
			$sum += $row[$num];
		}
		return $sum;
	}

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
	public function resortColsByNewHeader(array $newHeader)
	{
		$newTable = new RecordTable();
		foreach($newHeader as $name) {
			$col = $this->getColByName($name);
			$newTable->appendCol($col);
		}
		$newTable->setHeader($newHeader);
		return $newTable;
	}

	/**
	 * @param array $newHeader must be associative array with format:
	 * <code>
	 *      oldColName1 => newColName1
	 *      oldColName2 => newColName2
	 *      ...
	 * </code>
	 * Order is hold by order in array
	 * @return RecordTable
	 */
	public function renameColumns(array $newHeader)
	{
		$newTable = new RecordTable();
		foreach($newHeader as $oldname => $newname) {
			$col = $this->getColByName($oldname);
			$newTable->appendCol($col);
		}
		$newTable->setHeader( array_values($newHeader) );
		return $newTable;
	}

	/**
	 * @param array $col
	 * @param string $name
	 */
	public function appendCol(array $col, $name = "")
	{
		parent::appendCol($col);
		$this->header[] = $name;
	}

	/**
	 * @param string $name1
	 * @param string $name2
	 */
	public function swapColByNames($name1, $name2)
	{
		$col1 = $this->findColNum($name1);
		$col2 = $this->findColNum($name2);
		$this->swapCol($col1, $col2);
	}

	/**
	 * @param string $delimiter
	 * @param int $colSize
	 * @return string
	 */
	public function toStringWithHeader($delimiter = "\t", $colSize = 0) {
		$string = "";
		foreach($this->header as $name) {
			$string .= str_pad($name, $colSize) . $delimiter;
		}
		$string .= "\n";
		return $string . parent::toString($delimiter, $colSize);
	}

	/**
	 * @inheritdoc
	 */
	public function loadByHeader($data) {
		$this->table = [];
		$index = 0;
		foreach($data as $row) {
			foreach($this->header as $head) {
				$this->table[$index][] = $row[$head];
			}
			$index++;
		}
	}

	/**
	 * @param string $name
	 * @return int
	 * @throws TableException
	 */
	protected function findColNum($name) {
		foreach($this->header as $i => $n) {
			if($n == $name) {
				return $i;
			}
		}
		throw new TableException("In header is not column " . $name);
	}


}
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
	public function callToCol($name, $function, $params = null) {
		if(!is_numeric($name)) {
			$name = $this->findColNum($name);
		}
		parent::callToCol($name, $function, $params);
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
	 * Join columns into one
	 * @param array $cols columns to be join
	 * @param string|int $col
	 * @param null|callable $callback
	 * @throws InvalidCallback
	 */
	public function joinCols(array $cols, $col, $callback = null)
	{
		foreach($cols as &$colName) {
			if(is_string($colName)) {
				$colName = $this->findColNum($colName);
			}
		}

		if(is_null($callback)) {
			$callback = array('\Kedrigern\DataTable\Callback', 'defaultJoin');
		}

		if(!is_callable($callback)) {
			throw new InvalidCallback();
		}

		foreach($this->table as $key => &$row) {
			//TOOD: Params
			$params = array();
			foreach($cols as $colindex) {
				$params[] = $this->table[$key][$colindex];
			}
			$row[] = call_user_func_array($callback, array($params));
		}

		$this->header[] = $col;
	}

	/**
	 * Split column into many
	 * @param string|int $col to be splited
	 * @param array $cols of new column names
	 * @param null|callable $callback
	 * @throws InvalidCallback
	 */
	public function splitCol($col, array $cols, $callback = null)
	{
		if(is_null($callback)) {
			$callback = array('\Kedrigern\DataTable\Callback', 'defaultSplit');
		}

		if(!is_callable($callback)) {
			throw new InvalidCallback();
		}

		if(is_string($col)) {
			$col = $this->findColNum($col);
		}

		foreach($this->table as $key => &$row) {
			$result = call_user_func($callback, $row[$col]);
			if(count($result) != count($cols)) {
				throw new InvalidCallback();
			}

			foreach($result as $res) {
				$row[] = $res;
			}
		}

		$this->header = array_merge($this->header, $cols);
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
	 * @param bool $trim trim values of header
	 */
	public function useFirstRowAsHeader($trim = false) {
		$this->header = $this->table[0];
		unset($this->table[0]);
		$this->table =  array_values($this->table); // normalize indexes
		if($trim) {
			$this->trimHeader();
		}
	}

	/**
	 * Trim header
	 */
	public function trimHeader() {
		array_walk_recursive($this->header, function(&$val) {
			$val = $this->unicode_trim($val);
		});
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
	 *      oldColName1 => newColName1,
	 *      array('join', array(oldA, oldB), newColName2),
	 *      array('split', oldColName3, array(newA, newB)),
	 *      oldColName4 => newColName4
	 *      ...
	 * </code>
	 * Order is hold by order in array
	 * @return RecordTable
	 */
	public function renameColumns(array $newHeader)
	{
		$newTable = new RecordTable();
		foreach($newHeader as $oldname => $newname) {
			if(is_array($newname)) {
				if($newname[0] == 'join') {
					$this->joinCols($newname[1], $newname[2]);
					$newTable->appendCol($this->getColByName($newname[2]), $newname[2]);
				}
				if($newname[0] == 'split') {
					$this->splitCol($newname[1], $newname[2]);
					foreach($newname[2] as $col) {
						$newTable->appendCol($this->getColByName($col), $col);
					}
				}
			} else {
				$col = $this->getColByName($oldname);
				$newTable->appendCol($col, $newname);
			}
		}
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
	 * Remove rows if $callback return true
	 * @param callable $callback
	 * @param string $colName
	 * @param array $param another parameter for callback
	 * @return int number of removed rows
	 */
	public function removeRowsIfCol($callback, $colName, $param = [])
	{
		$modified = 0;

		$num = $this->findColNum($colName);

		foreach($this->table as $key => $row) {
			$cell = $row[$num];
			$ret = call_user_func_array($callback, [$cell, $param]);
			if($ret) {
				unset($this->table[$key]);
				$modified++;
			}
		}
		// normalize indexes
		$this->table = array_values($this->table);

		return $modified;
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
	 * @throws UnknownColName
	 */
	protected function findColNum($name) {
		if(is_numeric($name)) return intval($name);

		foreach($this->header as $i => $n) {
			if($n == $name) {
				return $i;
			}
		}
		throw new UnknownColName("In header is not column " . $name, 0, null, $name);
	}

	/**
	 * @param string $str
	 * @return string
	 */
	private static function unicode_trim ($str) {
		return preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','', $str);
	}
}
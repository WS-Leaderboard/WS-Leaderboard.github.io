<?php
/*
	OBJ
*/
class TableMaker {
	public $data = [];
	public $header = [];
	public $caret = '<i class="caret fa fa-caret-up"></i><i class="caret fa fa-caret-down"></i>';

	function __construct($f, $overide=[]) {
		$this->csvToArray(WSL_ROOT . $f, WSL_DELIMITER);
		if ( count($this->data) > 1 && is_array($this->data[0]) ) {
			$this->header = $this->data[0];
		}
		foreach( $this->header as $k => $v ){
			$this->header[$k] = ( isset($overide[$k]) ? $overide[$k] : ucfirst($k) );
		}
	}

	public function makeHeader(){
		$html = [];
		$html[] = "<tr>";
		foreach( $this->header as $k => $v ){
			$html[] = '<th class="tablesorter-header tablesorter-headerUnSorted"><span>'.$v. $this->caret . '</span></th>';
		}
		$html[] = "</tr>";
		return implode('',$html);
    }
	public function makeBody(){
		$html = [];
		foreach ($this->data as $k => $tr) {
			$html[] = "<tr>";
			foreach($tr as $td){
				$html[] = "<td>".trim($td)."</td>";
			}
			$html[] = "</tr>";
		}
		return implode('',$html);
	}
	/**
	* @link http://gist.github.com/385876
	*/
	private function csvToArray($filename='', $delimiter=';')
	{
		if(!file_exists($filename) || !is_readable($filename))
			return FALSE;

		$header = NULL;
		if (($handle = fopen($filename, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				foreach($row as $rk => $rv){ $row[$rk] = trim($rv); }
				if(!$header){
					$header = $row;
				} else {
					$this->data[] = array_combine($header, $row);
				}
			}
			fclose($handle);
		}
	}
}


?>
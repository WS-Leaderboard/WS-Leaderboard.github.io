<?php
/*
	OBJ
*/
class TableMaker {
	public $data = [];
	public $headeroveride = [];
	public $header = [];
	public $caret = '<i class="caret fa fa-caret-up"></i><i class="caret fa fa-caret-down"></i>';

	function __construct($f, $overide=[]) {
		$this->data = $this->csvToArray($f, ',');
		if ( count($this->data) > 1 && is_array($this->data[0]) ) {
			$this->header = $this->data[0];
		}
		$this->headeroveride = $overide;
	}

	public function makeHeader(){
		$html = [];
		$ov = $this->headeroveride;
		$html[] = "<tr>";
		foreach( $this->header as $k => $v ){
			$html[] = '<th class="tablesorter-header tablesorter-headerUnSorted"><span>'.( isset($ov[$k]) ? $ov[$k] : ucfirst($k) ). $this->caret . '</span></th>';
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
		$data = [];
		if (($handle = fopen($filename, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				foreach($row as $rk => $rv){ $row[$rk] = trim($rv); }
				if(!$header){
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}
			}
			fclose($handle);
		}
		return $data;
	}
}


?>
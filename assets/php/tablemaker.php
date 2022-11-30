<?php
	function makeHtmlTable($data){
		$html = [];
		foreach ($data as $k => $tr) {
			$html[] = "<tr>";
			foreach($tr as $td){
				$html[] = "<td>".trim($td)."</td>";
			}
			$html[] = "</tr>";
		}
		return implode('',$html);
	}
	function makeHtmlCaret(){
		return '<i class="caret fa fa-caret-up"></i><i class="caret fa fa-caret-down"></i>';
	}
    function makeHtmlTableHeader($data,$overide=[]){
        $html = [];
		if ( count($data) > 1 ) {
			$data = $data[0];
		}
        $html[] = "<tr>";
        foreach( $data as $k => $v ){
            $html[] = '<th class="tablesorter-header tablesorter-headerUnSorted"><span class="w3-button table-column">'.( isset($overide[$k]) ? $overide[$k] : ucfirst($k) ). makeHtmlCaret() . '</span></th>';
        }
        $html[] = "</tr>";
        return implode('',$html);
    }
	/**
	* @link http://gist.github.com/385876
	*/
	function csvToArray($filename='', $delimiter=';')
	{
		if(!file_exists($filename) || !is_readable($filename))
			return FALSE;

		$header = NULL;
		$data = [];
		if (($handle = fopen($filename, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
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
?>
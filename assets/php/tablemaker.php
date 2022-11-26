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
    function makeHtmlTableHeader($data){
        $html = [];
        $html[] = "<tr>";
        foreach( $data as $k => $v ){
            $html[] = '<th class="tablesorter-header tablesorter-headerUnSorted"><span class="w3-button table-column">'.$v. makeHtmlCaret() . '</span></th>';
        }
        $html[] = "</tr>";
        return implode('',$html);
    }
?>
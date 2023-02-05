<?php
/*
	OBJ
*/
class StatsMaker {

	//private $games;
	//private $rankings;
	/*
		CSV header fields
	*/
		// Rankings
	private $f_name		= 'corporation';
	private $f_rank		= 'rank';
	private $f_rating	= 'rating';
		// Games (archive)
	private $type		= [ 15=>'15v15', 10=>'10v10', 5=>'5v5' ];
	private $f_team1	= 'team1';
	private $f_team2	= 'team2';
	private $f_score1	= 'score1';
	private $f_score2	= 'score2';
	private $f_size		= 'players';
	private $f_date		= 'date';
		//
	public $day_short	= [ 'su', 'mo', 'tu', 'we', 'th', 'fr', 'sa' ];
	public $day_long	= [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
	/*
		STATS
	*/
	public $top;	// TOP 50
	public $cs;		// Corporation Statistics
	public $gs;		// Game Statistics
	public $rt20;	// Ratings of Top 20
	public $sbt20;	// Size Breakdown of Top 20
	public $asgs;	// All Submitted Game Sizes
	public $dwms;	// Day of Week for Match Start
	public $tc;		// Total Corporations
		// Help
	public $hct;	// HighChartTable Scripts
	/*
	***
		Construct Data
	***
	*/
	function __construct($rankings,$games,$tcorps){
		/*
			[
				'rankings'=> $rankings,
				'games'=> $games,
				'tcorps'=> $tcorps
			]

		*/
		//$this->games = $games;
		//$this->rankings = $rankings;

		for ( $t=0; $t<7; $t++ ){
			$this->dwms[] = 0;
		}
		$gs_totals = [];
		$corpall = [];
		/*
			TOP 50
		*/
		$t = 0;
		foreach($rankings as $d){
			if ($t<50) {
				//if ($d[$this->f_rank] > 0){
					$this->top[ $d[$this->f_name] ] = $d;
					if ($t<20) {
						$this->rt20[ $d[$this->f_name] ] = $d;
					}
					$t++;
				//}
			}else{
				break;
			}
		}
		foreach($games as $g ){
			$type = $this->type[ $g[$this->f_size] ];
			if ( $g[$this->f_size]>0 && isset($type)){
				// CS: Counts game types for each Corp
				$team1 = $g[$this->f_team1];
				$team2 = $g[$this->f_team2];
				if (isset($this->top[$team1])){
					$this->top[$team1][$type] += 1;
				}else{
					$corpall[$team1] +=1;
				}
				if (isset($this->top[$team2])){
					$this->top[$team2][$type] += 1;
				}else{
					$corpall[$team2] +=1;
				}
				$s1 = $g[$this->f_score1];
				$s2 = $g[$this->f_score2];
				$max = max( [$s1,$s2] );
				$diff = abs( $s1 - $s2 );
				// GS: Total Games
				$gs_totals[$type]['total'] += 1;
				// GS: Average Relics for Winner
				$gs_totals[$type]['relics'] += $max;
				// GS: Average Points Difference
				$gs_totals[$type]['diff'] += $diff;
				// GS: Highest Relics
				if ($max > $gs_totals[$type]['high']) {
					$gs_totals[$type]['high'] = $max;
					$gs_totals[$type]['highdate'] = $g[$this->f_date];
				}
				// GS: Percentage of Close* Games
				$d = round(($diff*100) / $max,2);
				if ( $d <= 30) {
					$gs_totals[$type]['close'] += $d;
					$gs_totals[$type]['closecount'] += 1;
				}
				// DWMS : Day of Week for Match Start
				// w : 0 (for Sunday) through 6 (for Saturday) (N : 1 (for Monday) through 7 (for Sunday) )
				$d = date('w', $this->makeTimeStamp($g[$this->f_date],-5) );
				$this->dwms[$d] += 1;
			}
		}

		// DWMS / calc % to max
		$dmax = max($this->dwms);
		foreach($this->dwms as $k => $v){
			$this->dwms[$k] = round( ($v*100)/$dmax, 1);
		}
		/*
			CS: Counting totals
		*/
		$t = 0;
		$cs_top20 = 0;
		$cs_top50 = 0;
		$cs_all = 0;
		$cs_most = 0;
		/*
			Count totals for Top20 and 50
		*/
		foreach($this->top as $v){
			$v5 = $v[$this->type[5]];
			$v10 = $v[$this->type[10]];
			$v15 = $v[$this->type[15]];
			$total = $v5 + $v10 + $v15;
			$n = $this->f_name;
			if ($t < 20){
				$cs_top20 += $total;
				$this->top[ $v[$n] ] = $d;
				$this->sbt20[] = [ $n => $v[$n], $this->type[5]=>$v5, $this->type[10]=>$v10, $this->type[15]=>$v15 ];
			}else{
				$cs_top50 += $total;
			}
			if ($total > $cs_most) { $cs_most = $total; }
			$t++;
		}
		/*
			Count totals for rest
		*/
		foreach($corpall as $total){
			$cs_all += $total;
			if ($total > $cs_most) { $cs_most = $total; }
		}
		/*
			ORGANIZE for outputs
		*/
			// CS
		$this->cs['top20'] = round(($cs_top20 / 20));
		$this->cs['top50'] = round((($cs_top20+$cs_top50) / 50));
		$this->cs['all'] = round((($cs_top20+$cs_top50+$cs_all) / (50+count($corpall))));
		$this->cs['most'] = $cs_most;
			// GS
		$total = 0;
		foreach($gs_totals as $k => $v){
			$total += $v['total'];
			$this->gs['total'][$k] = $v['total'];
			$this->gs['relics'][$k] = round($v['relics'] / $v['total']);
			$this->gs['diff'][$k] = round($v['diff'] / $v['total']);
			$this->gs['high'][$k] = $v['high'] . '<br>' . $v['highdate'];
			$this->gs['close'][$k] = round($v['close']/ $v['closecount'],1) . "%";
		}
			// ASGS
		foreach($this->type as $k){
			$this->asgs[$k] = round(($this->gs['total'][$k]*100)/$total,1);
		}
			// TC
			$this->tc = $tcorps;
	}
	/*
	***
		Support functions
	***
	*/
	private function makeTimeStamp($d,$inc=0){
        $d = explode('/',$d);
        // mktime(hour, minute, second, month, day, year) 
        return mktime(0, 0, 0, $d[1], $d[2]+$inc, $d[0]);
    }
	private function getClass($class){
		if (is_array($class)) { $class = implode(' ',$class); }
		return (empty($class)?'':' class="'.$class."'");
	}
	/*
	***
		HTML outputs
	***
	*/

	/*
		$gs = [
		'head'=>['name'=>'Game Statistics','15v15'=>'15 v 15', '10v10'=>'10 v 10', '5v5'=>'5 v 5'],
		'body' => [
			['name'=>'Total Games', 'total'=>'%'],
			['name'=>'Average Relics for Winner', 'relics'=>'%'],
			['name'=>'Average Points Difference', 'diff'=>'%'],
			['name'=>'Percentage of Close* Games', 'close'=>'%'],
			['name'=>'Highest Relics', 'high'=>'%']
				]
		];
	*/
	public function makeGS($table, $class=''){
		$html = [];
		$gs = $this->gs;
		$html[] = '<table'.$this->getClass($class).'><thead><tr>';
		$head = [];
		foreach($table['head'] as $k => $v){
			if ($k == 'name') {
				$v = '<h3>'.$v.'</h3>';
			}else{
				$head[] = $k;
			}
			$html[] = '<th>'.$v.'</th>';
		}
		$html[] = '</tr></thead><tbody>';
			foreach($table['body'] as $row){
				$html[] = '<tr>';
				foreach($row as $k => $v){
					if ($k == 'name') {
						$v = '<b>'.$v.'</b>';
						$html[] = '<td>'.$v.'</td>';
					}elseif ($v == "%") {
						foreach($head as $h){
							$html[] = '<td>'.$gs[$k][$h].'</td>';
						}
					}
				}	
				$html[] = '</tr>';
			}
		$html[] = '</tbody></table>';
		return implode('',$html);
	}
	/*
		$cs = [
		'head'=>['name'=>'Corporation Statistics','top20'=>'Top 20', 'top50'=>'Top 50', 'all'=>'All'],
		'body' => [
			['name'=>'Average Games per Corporation', 'top20'=>'%', 'top50'=>'%', 'all'=>'%'],
			['name'=>'Most Games Submitted', '' , '' , 'most'=>'%']
				]
		];
	*/
	public function makeCS($table, $class=''){
		$html = [];
		$cs = $this->cs;
		$html[] = '<table'.$this->getClass($class).'><thead><tr>';
			foreach($table['head'] as $k => $v){
				if ($k == 'name') { $v = '<h3>'.$v.'</h3>'; }
				$html[] = '<th>'.$v.'</th>';
			}
		$html[] = '</tr></thead><tbody>';
			foreach($table['body'] as $row){
				$html[] = '<tr>';
				foreach($row as $k => $v){
					if ($k == 'name') { $v = '<b>'.$v.'</b>'; }
					if ($v == "%") {
						$v = $cs[$k];
					}
					$html[] = '<td>'.$v.'</td>';
				}
				$html[] = '</tr>';
			}
		$html[] = '</tbody></table>';
		return implode('',$html);
	}
	public function makeASGS($class = "AllSubmitedGameSizes"){
		$html = [];
		$xaxis = [];
		$series = [];
		foreach($this->asgs as $k => $v){
			$xaxis[] = $k;
			$series[] = [ 'y'=> intval($v), 'label'=>$k ] ;
		}
		$html[] = '<div id="'.$class.'"></div>';
		$this->hct[] = "Highcharts.chart('".$class."', {
			chart: {
				type: 'pie'
			},
			xAxis: {
				categories: ".json_encode($xaxis).",
			},
			yAxis:{
				title: null,
				max: 100
			},
			credits: {
				enabled: false
			},
			title: {
				text: null
			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					colors: ['#5891AD','#F1C232','#004561'],
					dataLabels: {
						enabled: true,
							formatter: function () {
								return '<b>' + this.point.label + '<br> ' + this.point.y + '%</b>';
							}
					}
				}
			},
			 
			tooltip: {
				formatter: function() {
					return '<b>' + this.point.y + '%</b> : ' + this.point.label;
				},
			},
			series: [{
				name: 'Corporations',
				innerSize: '50%',
				data: ".json_encode($series)."
			}]
		});";
		return implode('',$html);		
	}
	public function makeSBT20($class = "SizeBreakDownOfTop20"){
		$html = [];
		$xaxis = [];
		$seriesA = [];
		$seriesB = [];
		$seriesC = [];
		foreach($this->sbt20 as $k => $v){
			$xaxis[] = $v[$this->f_name];
			$seriesA[] = [ intval($v[$this->type[5]]) ];
			$seriesB[] = [ intval($v[$this->type[10]]) ];
			$seriesC[] = [ intval($v[$this->type[15]]) ];
		}
		$html[] = '<div id="'.$class.'"></div>';
		$this->hct[] = "Highcharts.chart('".$class."', {
			chart: {
				type: 'column'
			},
			xAxis: {
				categories: ".json_encode($xaxis).",
				crosshair: true
			},
			yAxis:{
				title: null,
			},
			credits: {
				enabled: false
			},
			title: {
				text: null
			},
			legend: {
				enabled: true
			},
			colors: ['#5891AD','#F1C232','#004561'],
			plotOptions: {
				column: {
					stacking: 'percent'
				},
				series: {
					dataLabels: {
						enabled: false,
							formatter: function () {
								return this.point.label;
							}
					}
				}
			},
			 
			tooltip: {
				formatter: function() {
					return '<b>' + (this.point.percentage).toFixed(0) + '%</b> : ' + this.series.name;
				},
			},
			series: [
				{ name: '".$this->type[5]."',
				data: ".json_encode($seriesA)."},
				{ name: '".$this->type[10]."',
				data: ".json_encode($seriesB)."},
				{ name: '".$this->type[15]."',
				data: ".json_encode($seriesC)."}
			]
		});";
		return implode('',$html);
	}
	public function makRT20($class = "RattingsOfTop20"){
		$html = [];
		$xaxis = [];
		$series = [];
		foreach($this->rt20 as $k => $v){
			$rank = $v[$this->f_rank];
			$xaxis[] = $v[$this->f_name];
			if ($rank>0) {
				$color = '#F1C232';
			}else{
				$color = '#FFE599';
			}
			$series[] = [ 'y'=> intval($v[$this->f_rating]), 'label'=>$v[$this->f_name],'rank'=> ($rank?$rank:'~'), 'color'=>$color ] ;
		}
		$html[] = '<div id="'.$class.'"></div>';
		$this->hct[] = "Highcharts.chart('".$class."', {
			chart: {
				type: 'column'
			},
			xAxis: {
				categories: ".json_encode($xaxis).",
				crosshair: true
			},
			yAxis:{
				title: null,
			},
			credits: {
				enabled: false
			},
			title: {
				text: null
			},
			legend: {
				enabled: false
			},
			colors: ".json_encode($colors).",
			plotOptions: {
				series: {
					dataLabels: {
						enabled: false,
							formatter: function () {
								return this.point.label;
							}
					}
				}
			},
			 
			tooltip: {
				formatter: function() {
					return this.point.rank + '. <b>' + this.point.y + '</b> : ' + this.point.label;
				},
			},
			series: [{
				name: 'Corporations',
				data: ".json_encode($series)."
			}]
		});";
		return implode('',$html);
	}
	public function makeDWMS($class = "DatOfWeekForMatch"){
		$html = [];
		$xaxis = [];
		$series = [];
		foreach($this->dwms as $k => $v){
			$xaxis[] = $this->day_long[$k];
			$series[] = [ 'y'=> intval($v), 'label'=>$this->day_long[$k] ] ;
		}
		$html[] = '<div id="'.$class.'"></div>';
		$this->hct[] = "Highcharts.chart('".$class."', {
			chart: {
				type: 'column'
			},
			xAxis: {
				categories: ".json_encode($xaxis).",
				crosshair: true
			},
			yAxis:{
				title: null,
				max: 100
			},
			credits: {
				enabled: false
			},
			title: {
				text: null
			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					color: '#F1C232',
					dataLabels: {
						enabled: false,
							formatter: function () {
								return this.point.label;
							}
					}
				}
			},
			 
			tooltip: {
				formatter: function() {
					return '<b>' + this.point.y + '%</b> : ' + this.point.label;
				},
			},
			series: [{
				name: 'Corporations',
				data: ".json_encode($series)."
			}]
		});";
		return implode('',$html);
	}
	//https://chartscss.org/
	public function makeScripts(){
		return "<script>$(document).ready(function() { ". implode('',$this->hct) . " });</script>";
	}
	public function makeTC($class = "TotalCorporations"){
		$html = [];
		$xaxis = [];
		$series = [];
		foreach($this->tc as $k => $v){
			$xaxis[] = $v['Date'];
			$series[] = [ 'y'=> intval($v['Corporations']), 'label'=>$v['Version'] ] ;
		}
		$html[] = '<div id="'.$class.'"></div>';
		$this->hct[] = "Highcharts.chart('".$class."', {
			xAxis: {
				categories: ".json_encode($xaxis).",
				crosshair: true
			},
			yAxis:{
				title: null
			},
			credits: {
				enabled: false
			},
			title: {
				text: null
			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					color: '#004561',
					dataLabels: {
						enabled: true,
							formatter: function () {
								return this.point.label;
							}
					}
				}
			},
			 
			tooltip: {
				formatter: function() {
					return '<b>' + this.point.y + '</b> : ' + this.point.label;
				},
			},
			series: [{
				name: 'Corporations',
				data: ".json_encode($series)."
			}]
		});";
		return implode('',$html);
	}
}

?>
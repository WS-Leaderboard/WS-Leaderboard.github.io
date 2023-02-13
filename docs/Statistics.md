### /assets/php/StatsMaker.php
### use -> /assets/js/highcharts.js

---

# Data prepare
Start with new instance which loads all needed data from CSV files, ```$st = new StatsMaker();```

## Config IF(!) CSV headers will change
This settings are hardcoded since it could be taken from CSV directly
but in case columns order change it would be not detected properly.

// Rankings
```
private $f_name		= 'corporation';
private $f_rank		= 'rank';
private $f_rating	= 'rating';
```
// Games (archive)
```
private $type		= [ 15=>'15v15', 10=>'10v10', 5=>'5v5' ];
private $f_team1	= 'team1';
private $f_team2	= 'team2';
private $f_score1	= 'score1';
private $f_score2	= 'score2';
private $f_size		= 'players';
private $f_date		= 'date';
```
// Day name

```
private $day_short	= [ 'su', 'mo', 'tu', 'we', 'th', 'fr', 'sa' ];
private $day_long	= [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
```
// Colors, set charts colors since it can not be set by style classes due to wrong display on mobiles. Colordef set default, base color.

```
private $colors	= ['#FFE599','#5891AD','#F1C232','#004561'];
private $colordef = 2;
```


# Tables
Second optional argument set html CLASS. Tables present different data preparation due to possible row order change, so they are pulled out of asset.

## Global Statistics
Prepare data
```
$cs = [
	'head'=>['name'=>'Corporation Statistics','top20'=>'Top 20', 'top50'=>'Top 50', 'all'=>'All'],
	'body' => [
		['name'=>'Average Games per Corporation', 'top20'=>'%', 'top50'=>'%', 'all'=>'%'],
		['name'=>'Most Games Submitted', '' , '' , 'most'=>'%']
			]
	];
```
Use ```echo $st->makeCS($cs)```

## Game Statistics
Prepare data
```
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
```
Use ```echo $st->makeGS($gs)```

# Charts
Optional argument set html ID.
If adding charts there need to be included js assets like so ```TemplateMaker::Footer(['highcharts.js', $st->makeScripts()])```. **$st->makeScripts()** outputs all needed scripts to build charts.

## Ratings of Top 20
Type: column
Use ```echo $st->makRT20()```

## Size Breakdown of Top 20
Type: column stacked
Use: ```echo $st->makeSBT20()```

## All Submitted Game Sizes
Type: pie / donut
Use: ```echo $st->makeASGS()```

## Day of Week for Match Start
Type: column
Use: ```echo $st->makeDWMS()```

## Total Corporations
Type: line
Use: ```echo $st->makeTC()```
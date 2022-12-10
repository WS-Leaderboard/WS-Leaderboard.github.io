<?php
header('Content-Type: text/plain; charset=utf-8');
include_once '../assets/php/tablemaker.php';

$f = '../data/full_rankings.csv';
$header = ["delta"=>"Δ"];
$t = new TableMaker($f,$header);
echo '<thead>' . $t->makeHeader() . '</thead><tbody id="full_list">'. $t->makeBody() . '</tbody>';
?>
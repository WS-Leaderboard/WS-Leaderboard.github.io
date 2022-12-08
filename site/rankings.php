<?php
header('Content-Type: text/plain; charset=utf-8');
include '../assets/php/tablemaker.php';

$f = '../data/full_rankings.csv';
$rankings = csvToArray($f, ',');
$header = ["delta"=>"Δ"];
echo '<thead>' . makeHtmlTableHeader($rankings,$header) . '</thead><tbody id="full_list">'. makeHtmlTable($rankings) . '</tbody>';
?>
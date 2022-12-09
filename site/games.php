<?php
header('Content-Type: text/plain; charset=utf-8');
include_once '../assets/php/tablemaker.php';

$f = '../data/full_archive.csv';
$header = ["team1"=>"Team 1", "score1"=>"Score 1", "score2"=>"Score 2", "team2"=>"Team 2"];
$t = new TableMaker($f,$header);
echo '<thead>' . $t->makeHeader() . '</thead><tbody id="full_list">' . $t->makeBody() . '</tbody>';
?>
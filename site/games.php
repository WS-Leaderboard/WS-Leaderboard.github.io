<?php
header('Content-Type: text/plain; charset=utf-8');
include '../assets/php/tablemaker.php';

$f = '../data/full_archive.csv';
$games = csvToArray($f, ',');
$header = ["team1"=>"Team 1", "score1"=>"Score 1", "score2"=>"Score 2", "team2"=>"Team 2"];
echo '<thead>' . makeHtmlTableHeader($games,$header) . '</thead><tbody id="full_list">' . makeHtmlTable($games) . '</tbody>';
?>
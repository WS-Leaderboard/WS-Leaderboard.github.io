<?php
header('Content-Type: text/plain; charset=utf-8');
$games = include '../../data/games.php';
include 'tablemaker.php';
echo '<thead>' . makeHtmlTableHeader(["Team 1", "Score 1", "Score 2", "Team 2","Players","Date"]) . '</thead><tbody id="full_list">' . makeHtmlTable($games) . '</tbody>';

?>
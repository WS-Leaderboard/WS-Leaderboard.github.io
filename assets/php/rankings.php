<?php
header('Content-Type: text/plain; charset=utf-8');
$rankings = include '../../data/rankings.php';
include 'tablemaker.php';
echo '<thead>' . makeHtmlTableHeader(["Rank", "Corporation", "Rating", "Δ"]) . '</thead><tbody id="full_list">'. makeHtmlTable($rankings) . '</tbody>';
?>
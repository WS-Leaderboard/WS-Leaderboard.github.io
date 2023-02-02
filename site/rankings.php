<?php
header('Content-Type: text/plain; charset=utf-8');

$f = '../' . WSL_PATH_RANKINGS;
$header = ["delta"=>"Δ"];
$t = new TableMaker($f,$header);
echo '<thead>' . $t->makeHeader() . '</thead><tbody id="full_list">'. $t->makeBody() . '</tbody>';
?>
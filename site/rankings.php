<?php
header('Content-Type: text/plain; charset=utf-8');

$header = ["delta"=>"Δ"];
$t = new TableMaker(WSL_PATH_RANKINGS,$header);
echo '<thead>' . $t->makeHeader() . '</thead><tbody id="full_list">'. $t->makeBody() . '</tbody>';
?>
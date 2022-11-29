<?php
/*
    Get name of script like this
        you execute /get-ranking.php
    so it gets name from this RANKING (after dash)
    and do sync http://domain/site/rankings.php to directory /site/rankings.html
*/
function getSync(){
    preg_match('/.*-([a-z]*).php/', $_SERVER["SCRIPT_NAME"], $name);
    $name = '/site/'.$name[1].'s.';

    $url = explode(":",$_SERVER["SCRIPT_URI"]);
    $url = $url[0] . "://". $_SERVER["HTTP_HOST"];
    $site = $url . $name .'php';

    $homepage = @file_get_contents($site);
    if ( $homepage !== FALSE ) {
        $filename = '.'.$name.'html';
        $handle = fopen($filename,"w");
        fwrite($handle,$homepage);
        fclose($handle);
    }
}
?>
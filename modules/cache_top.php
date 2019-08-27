<?php
/*
* cache_top.php
* -------------
* Logic for caching. This file need to be added at top of the file header
* Basis for the caching system: https://pixeltuner.de/php-cache-erstellen/
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/
$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile = 'cache/'.substr_replace($file ,"",-4).'.html';
$cachetime = 18000;
 
// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
    include($cachefile);
    exit;
}
ob_start(); // Start the output buffer
?>
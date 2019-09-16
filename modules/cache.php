<?php
/*
* cache.php
* ---------
* Logic for caching. This file need to be added at top of the file header.
* At the end of the cached content the function writeCacheFile() needs to
* be called with the cache file name as parameter.
* Basis for the caching system: https://pixeltuner.de/php-cache-erstellen/
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

// Starting caching
$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$config["cacheFile"] = 'cache/'.substr_replace($file ,"",-4).'.html';
$cachetime = 18000;
 
// Serve from the cache if it is younger than $cachetime
if (file_exists($config["cacheFile"]) && time() - $cachetime < filemtime($config["cacheFile"])) {
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($config["cacheFile"]))." -->\n";
    include($config["cacheFile"]);
    exit;
}
// Start the output buffer
ob_start();

/**
* Save content from page to file.
*
* @param string $cacheFile  File name in which the content will be cached
*
* @Author: David Hein
*/
function writeCacheFile($cacheFile) {
    $cached = fopen($cacheFile, 'w');
    fwrite($cached, ob_get_contents());
    fclose($cached);
    ob_end_flush(); // Send the output to the browser
}

?>
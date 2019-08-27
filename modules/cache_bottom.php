<?php
/*
* cache_bottom.php
* ----------------
* Logic for caching. This file need to be added at bottom of the file header
* Basis for the caching system: https://pixeltuner.de/php-cache-erstellen/
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

// Cache the contents to a file
$cached = fopen($cachefile, 'w');
fwrite($cached, ob_get_contents());
fclose($cached);
ob_end_flush(); // Send the output to the browser
?>
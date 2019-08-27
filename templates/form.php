<?php
/*
* form.php
* --------
* Template for a form.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

function betterEval($code) {
    $tmp = tmpfile ();
    $tmpf = stream_get_meta_data ( $tmp );
    $tmpf = $tmpf ['uri'];
    fwrite ( $tmp, $code );
    $ret = include ($tmpf);
    fclose ( $tmp );
    return $ret;
}

class form {
    public $accessPermission;
    public $returnPage;
    
    public $linkPermission;
    public $linkElement;
    
    public $heading;
    
    public $caching;
    
    function __construct() {
        $this -> accessPermission   = false;
        $this -> returnPage         = "index.php";
        
        $this -> linkPermission     = false;
        $this -> linkElement        = '<a href="index.php">Startseite</a>';
        
        $this -> heading            = "Überschrift";
        
        $this -> caching            = "false";
    }
    
    function show($ownCode = "") {        
        betterEval(
            file_get_contents('modules/header_user.php') .
            file_get_contents('modules/permissionCheck.php').
            "<?php 
            // Check permission
            if(!" . $this -> accessPermission . ") {
                header(\"Location: " . $this -> returnPage . "\");
                exit();
            } ?>" .
            // Caching
            "<?php if(" . $this -> caching . ") { ?>" . file_get_contents('modules/cache_top.php') . " <?php } ?>" .
            file_get_contents('modules/header.php') .
            "<h1>" . $this -> heading . "</h1>" .
            "<p>" .
            "<?php if(" . $this -> linkPermission . ") {?>" . $this -> linkElement . "<?php } ?>" .
            "</p>" .
            // Code of child class
            (string)$ownCode .
            // Caching
            "<?php if(" . $this -> caching . ") {?>" . file_get_contents('modules/cache_bottom.php') . "<?php } ?>");
    }
}

?>
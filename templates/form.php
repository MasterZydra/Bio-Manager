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

/**
* Executing given PHP code
*
* Source of function: https://www.php.net/manual/en/function.eval.php
*
* @param $code  PHP code which shall be executed
*
* @return HTML code
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

/**
* The class form is generating an HTML template. The content
* is set through properties. Indiviudal code can be added too.
*
* With heredity the class can be expanded for specialized pages.
*
* @author David Hein
*/
class form {
    /**
    * Permission that is necessary to access this page. The string is inserted as if condition. E.g. "isMaintainer()"
    * @var string
    */
    public $accessPermission;
    /**
    * This page will be called if the user has not enough permission to access the page. E.g. "user.php"
    * @var string
    */
    public $returnPage;
    
    /**
    * Permission that is necessary to view the elements in $linkElement. The string is inserted as if condition. E.g. "true" or "isMaintainer()"
    * @var string
    */
    public $linkPermission;
    /**
    * HTML code which will be shown if $linkPermission is true. E.g. '<a href="pricing.php">Alle Preise anzeigen</a>'
    * @var string
    */
    public $linkElement;
    
    /**
    * H1 heading which is shown on the page content.
    * @var string
    */
    public $heading;
    
    /**
    * Flag if caching shall be activated for the page. The default value is "false". To activate caching set the value to "true".
    * @var string
    */
    public $caching;
    
    /**
    * Construct a new form object and set default values for the properties
    *
    * @author David Hein
    */
    function __construct() {
        $this -> accessPermission   = false;
        $this -> returnPage         = "index.php";
        
        $this -> linkPermission     = false;
        $this -> linkElement        = '<a href="index.php">Startseite</a>';
        
        $this -> heading            = "Überschrift";
        
        $this -> caching            = "false";
    }
    
    /**
    * Show the page content
    *
    * @param string $ownCode    If this parameter is set, the given string will be excuted
    *
    * @author David Hein
    */
    function show($ownCode = "") {        
        betterEval(
            file_get_contents('modules/header_user.php') .
            file_get_contents('modules/permissionCheck.php').
            // Check permission
            "<?php
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
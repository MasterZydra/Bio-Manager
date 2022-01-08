<?php

/*
* Form.php
* --------
* Template for a form.
*
* @Author: David Hein
*/

include 'modules/permissionCheck.php';

/**
* The class form is generating an HTML template. The content
* is set through properties. Indiviudal code can be added too.
*
* With heredity the class can be expanded for specialized pages.
*
* @author David Hein
*/
class Form
{
    /**
    * Permission that is necessary to access this page.
    * If it is a string e.g. "isMaintainer", the function will be executed.
    * If it is a boolean, it will directly used as permission check.
    * @var string/boolean
    */
    public $accessPermission;
    /**
    * This page will be called if the user has not enough permission
    * to access the page. E.g. "user.php"
    * @var string
    */
    public $returnPage;

    /**
    * Permission that is necessary to view the elements in $linkElement.
    * If it is a string e.g. "isMaintainer", the function will be executed.
    * If it is a boolean, it will directly used as permission check.
    * @var string/boolean
    */
    public $linkPermission;
    /**
    * HTML code which will be shown if $linkPermission is true.
    * E.g. '<a href="pricing.php">Alle Preise anzeigen</a>'
    * @var string
    */
    public $linkElement;

    /**
    * H1 heading which is shown on the page content.
    * @var string
    */
    public $heading;

    /**
    * Flag if caching shall be activated for the page.
    * The default value is "false". To activate caching set the value to "true".
    * @var boolean
    */
    public $caching;

    /**
    * Config for other contents. It is e.g. used for transfer the cache file name.
    * @var array
    */
    protected $config;

    /**
    * Construct a new form object and set default values for the properties
    *
    * @author David Hein
    */
    public function __construct()
    {
        $this -> accessPermission   = false;
        $this -> returnPage         = "index.php";

        $this -> linkPermission     = false;
        $this -> linkElement        = '<a href="index.php">Startseite</a>';

        $this -> heading            = "Überschrift";

        $this -> caching            = false;

        $this -> config["cacheFile"] = "";
    }

    /**
    * Head part of a page. It contains permission check, caching and heading.
    *
    * @author David Hein
    */
    protected function head()
    {
        include 'modules/header_user.php';

        // Execute access permission function
        if (is_string($this -> accessPermission)) {
            $permissionFunc = $this -> accessPermission;
            $this -> accessPermission = $permissionFunc();
        }

        // Execute link permission function
        if (is_string($this -> caching)) {
            $permissionFunc = $this -> caching;
            $this -> caching = $permissionFunc();
        }

        // Check permission
        if (!$this -> accessPermission) {
            header("Location: " . $this -> returnPage);
            exit();
        }

        // Caching
        if ($this -> caching) {
            include 'modules/cache.php';
            $this -> config["cacheFile"] = $config["cacheFile"];
        }

        include 'modules/header.php';

        // Heading and link
        echo "<h1>" . $this -> heading . "</h1>";
        echo "<p>";
        if ($this -> linkPermission) {
            echo $this -> linkElement;
        }
        echo "</p>";
    }

    /**
    * Foot part of a page. It contains the closing the footer
    * and part of caching.
    *
    * @author David Hein
    */
    protected function foot()
    {
        include 'modules/footer.php';

        // Caching
        if ($this -> caching) {
            writeCacheFile($this -> config["cacheFile"]);
        }
    }

    /**
    * Main function which calls all parts that will be executed.
    * It creates the page which will be shown.
    *
    * @author David Hein
    */
    public function show()
    {
        $this -> head();
        $this -> foot();
    }
}

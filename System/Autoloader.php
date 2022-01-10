<?php

namespace System;

spl_autoload_register(
    function ($class)
    {
        $PREFIX = 'System\\';
        if (!str_starts_with($class, $PREFIX)) {
            return;
        }
        $fileName = str_replace($PREFIX, '' , $class);
        $fileName = __DIR__.DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $fileName).'.php';
        echo "<br/>Filename: ";
        echo $fileName;
        echo "<br/>";
        if (file_exists($fileName)) {
            require_once $fileName;
        }
    });
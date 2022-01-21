<?php

function getSecuredString(string $string)
{
    return htmlspecialchars(trim($string));
}

function secPOST(string $name)
{
    if (!isset($_POST[$name])) {
        return null;
    }
    $value = $_POST[$name];
    if (!is_string($value)) {
        return $value;
    }
    return getSecuredString($value);
}

function secGET(string $name)
{
    if (!isset($_GET[$name])) {
        return null;
    }
    $value = $_GET[$name];
    if (!is_string($value)) {
        return $value;
    }
    return getSecuredString($value);
}

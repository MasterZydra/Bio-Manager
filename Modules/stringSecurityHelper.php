<?php

function getSecuredString(string $string)
{
    return htmlspecialchars(trim($string));
}

function secPOST($name)
{
    return getSecuredString($_POST[$name]);
}

function secGET($name)
{
    return getSecuredString($_GET[$name]);
}

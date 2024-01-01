<?php

namespace Framework\Routing;

use Exception;
use Framework\Config\Config;
use Framework\Facades\URL;

/** The `BaseController` can be used as base class for commands to get access to helper functions. */
abstract class BaseController
{
    /** Returns the request method (`GET`, `POST`, etc.) */
    public function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /** Returns the parameter for GET and POST */
    public function getParam(string $name, mixed $default = null): mixed
    {
        if ($this->getRequestMethod() === 'GET') {
            if (!array_key_exists($name, $_GET)) {
                return $default;
            }
            return $_GET[$name];
        }

        if ($this->getRequestMethod() === 'POST') {
            if (!array_key_exists($name, $_POST)) {
                return $default;
            }
            return $_POST[$name];
        }

        throw new Exception(__METHOD__ . ': The method "' . $this->getRequestMethod() . '" is not implemented');
    }
}
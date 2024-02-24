<?php

namespace Framework\Database;

use Exception;

/** The DeleteOperationNotAllowedException is thrown if a entity is not allowed to be deleted */
class DeleteOperationNotAllowedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Deleting the given model is not allowed');
    }
}
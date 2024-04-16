<?php

namespace Framework\Database\Exception;

use Exception;

/** The EditOperationNotAllowedException is thrown if a entity is not allowed to be edited */
class EditOperationNotAllowedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Editing the given model is not allowed');
    }
}
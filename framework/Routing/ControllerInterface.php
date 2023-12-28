<?php

namespace Framework\Routing;

interface ControllerInterface
{
    /** Execute the controller logic */
    public function execute(): void;
}

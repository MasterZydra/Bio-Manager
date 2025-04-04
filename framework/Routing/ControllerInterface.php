<?php

declare(strict_types = 1);

namespace Framework\Routing;

interface ControllerInterface
{
    /** Execute the controller logic */
    public function execute(): void;
}

<?php

declare(strict_types = 1);

namespace Framework\Cli;

/** Every command that shall be available in the bioman CLI must implement this interface */
interface CommandInterface
{
    public function execute(array $args): int;
    public function getName(): string;
    public function getDescription(): string;
}
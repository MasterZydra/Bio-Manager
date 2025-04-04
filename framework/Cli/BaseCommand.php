<?php

declare(strict_types = 1);

namespace Framework\Cli;

/**
 * The BaseCommand class can be used as base class for custom commands.
 * It provides helper functions e.g. for user input or printing to the terminal.
 */
abstract class BaseCommand
{
    public function input(string $prompt): string
    {
        return readline($prompt . ' ');
    }
}
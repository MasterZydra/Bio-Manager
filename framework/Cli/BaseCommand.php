<?php

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

    public function printLn(string $output): void
    {
        echo $output . PHP_EOL;
    }

    public function print(string $output): void
    {
        echo $output;
    }
}
<?php

use Framework\Facades\Path;
use Framework\i18n\Translator;

/** Print the given string with line break */
function printLn(string $output): void
{
    echo $output . PHP_EOL;
}

/** Render the given view */
function view(string $name, array $data = []): void
{
    if (count($data) > 0) {
        extract($data);
    }
    require Path::join(__DIR__,  '..', 'resources', 'Views', str_replace('.', '/', $name) . '.php');
}

/** Render the given component */
function component(string $name, array $data = []): void
{
    if (count($data) > 0) {
        extract($data);
    }
    require Path::join(__DIR__, '..', 'resources', 'Views', 'Components', str_replace('.', '/', $name) . '.php');
}

/** Translate the given label into user language */
function __(string $label): string
{
    return Translator::translate($label);
}
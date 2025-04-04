<?php

declare(strict_types = 1);

use App\Models\Setting;
use Framework\Facades\Path;
use Framework\Facades\Str;
use Framework\i18n\Translator;

/** Print the given string with line break */
function printLn(string $output): void
{
    echo $output . PHP_EOL;
}

/** Render the given view and return the HTML */
function render(string $name, array $data = []): string
{
    ob_start();
    if (count($data) > 0) {
        extract($data);
    }
    require Path::join(__DIR__,  '..', 'resources', 'Views', str_replace('.', '/', $name) . '.php');
    $html = ob_get_contents();
    ob_end_clean();
    return Str::removeLeadingLineSpaces($html);
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
function component(string $name, array $data = [], bool $once = false): void
{
    if (count($data) > 0) {
        extract($data);
    }
    $path = Path::join(__DIR__, '..', 'resources', 'Views', 'Components', str_replace('.', '/', $name) . '.php');
    if ($once) {
        require_once $path;
    } else {
        require $path;
    }
}

/** Translate the given label into user language */
function __(string $label, ...$values): string
{
    return Translator::translate($label, ...$values);
}

/** Get value for given settings name */
function setting(string $name): string
{
    return Setting::findByName($name)->getValue();
}
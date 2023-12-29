<?php

use Framework\i18n\Translator;

/** Render the given view */
function view(string $name, array $data = []): void
{
    if (count($data) > 0) {
        extract($data);
    }
    require Path::join(__DIR__,  '..', 'resources', 'views', str_replace('.', '/', $name) . '.php');
}

/** Render the given component */
function component(string $name, array $data = []): void
{
    if (count($data) > 0) {
        extract($data);
    }
    require Path::join(__DIR__, '..', 'resources', 'views', 'components', str_replace('.', '/', $name) . '.php');
}

/** Translate the given label into user language */
function __(string $label): string
{
    return Translator::translate($label);
}
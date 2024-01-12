<?php

namespace Framework;

spl_autoload_register(
    function ($class) {
        $prefixes = [
            'Framework\\' => '',
            'App\\' => 'app\\',
            'Resources\\' => 'resources\\',
        ];

        foreach ($prefixes as $prefix => $dir) {
            if (!str_starts_with($class, $prefix)) {
                continue;
            }

            $filename = str_replace($prefix, $dir, $class);
            if ($dir === '') {
                $filename = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $filename) . '.php';
            } else {
                $filename = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $filename) . '.php';
            }

            if (!file_exists($filename)) {
                throw new \Exception('Requested file "' . $class . '" not found');
            }
            
            require_once $filename;
            return;
        }
    }
);

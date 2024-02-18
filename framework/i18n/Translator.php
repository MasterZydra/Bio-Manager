<?php

namespace Framework\i18n;

use Framework\Config\Config;
use Framework\Facades\File;
use Framework\Facades\Path;

class Translator
{
    private static string $languageDir = '';
    private static array $labels = [];

    /** Read all label files and store the labels inside this class */
    public static function readLabelFiles(string $languageDir = null): void
    {
        // Store new language directory
        if ($languageDir !== null) {
            self::$languageDir = $languageDir;
        } else {
            self::$languageDir = Path::join(__DIR__, '..', '..', 'resources', 'Lang');
        }

        // Get all files in the language directory
        $languageFiles = File::findFilesInDir(self::$languageDir, onlyFiles: true);
        if (count($languageFiles) === 0) {
            self::$labels = [];
            return;
        }

        /** @var string $languageFile */
        foreach ($languageFiles as $languageFile) {
            if (!self::isLanguageFile($languageFile)) {
                continue;
            }

            $lang = require Path::join(self::$languageDir, $languageFile);

            self::$labels[self::getLanguage($languageFile)] = $lang;
        }
    }

    /** Translate the given label into user language */
    public static function translate(string $label): string
    {
        $lang = Language::getLanguage();
        if (!array_key_exists($lang, self::$labels)) {
            $lang = Config::env('APP_LANG');
        }

        if (!array_key_exists($lang, self::$labels) || !(array_key_exists($label, self::$labels[$lang]))) {
            // TODO How to handle untranslated labels
            // Maybe if in dev mode -> error / warning 
            // In prod mode return label?
            return $label;
        }
        return self::$labels[$lang][$label];
    }

    /** Get the language code from the given filename */
    private static function getLanguage(string $filename): string
    {
        return str_replace('.php', '', $filename);
    }

    /** Check if the given filename is a valid language file */
    private static function isLanguageFile(string $filename): bool
    {
        // A language file cannot start with a dot e.g. 'de.php'
        if (str_starts_with($filename, '.')) {
            return false;
        }
        // A language file must be a PHP file
        if (!str_ends_with($filename, '.php')) {
            return false;
        }
        return true;
    }
}
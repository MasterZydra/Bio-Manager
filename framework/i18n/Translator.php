<?php

namespace Framework\i18n;

class Translator
{
    private static string $languageDir = __DIR__ . '/../../resources/lang';
    private static array $labels = [];

    /** Read all label files and store the labels inside this class */
    public static function readLabelFiles(string $languageDir = null): void
    {
        // Store new language directory
        if ($languageDir !== null) {
            self::$languageDir = $languageDir;
        }

        // Get all files in the language directory
        $languageFiles = scandir(self::$languageDir);
        if ($languageFiles === false) {
            self::$labels = [];
            return;
        }

        /** @var string $languageFile */
        foreach ($languageFiles as $languageFile) {
            if (!self::isLanguageFile($languageFile)) {
                continue;
            }

            $lang = require rtrim(self::$languageDir, '/') . DIRECTORY_SEPARATOR . $languageFile;

            self::$labels[self::getLanguage($languageFile)] = $lang;
        }
    }

    /** Translate the given label into user language */
    public static function translate(string $label): string
    {
        // TODO get language from session ...
        $lang = Language::getBrowserLanguage();
        if (!array_key_exists($lang, self::$labels)) {
            // TODO Fallback language en -> later as setting?
            $lang = 'en';
        }

        if (!(array_key_exists($label, self::$labels[$lang]))) {
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
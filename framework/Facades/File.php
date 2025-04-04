<?php

declare(strict_types = 1);

namespace Framework\Facades;

class File
{
    /** Get an array with all files in the given directory */
    public static function findFilesInDir(string $path, bool $recursive = false, bool $onlyFiles = false, bool $onlyDirs = false): array
    {
        $allFiles = scandir($path);
        if ($allFiles === false) {
            return [];
        }

        // Remove the entries '.' and '..'
        $allFiles = array_filter($allFiles, fn($file) => $file !== '.' && $file !== '..');

        if ($recursive) {
            // In case of recursive search call this function for the subdirectories
            $allSubdirFiles = [];
            $filteredOnlyFiles = self::filterOnlyDirs($path, $allFiles);
            foreach ($filteredOnlyFiles as $file) {
                $subpath = Path::join($path, $file);
                if (!is_dir($subpath)) {
                    continue;
                }
    
                // Add subdirectory to file path
                $subdirFiles = self::findFilesInDir($subpath, recursive: true);
                $subdirFiles = array_map(fn($v) => Path::join($file, $v) , $subdirFiles);
                array_push($allSubdirFiles, $subdirFiles);
            }

            // Merge all files from the subdirectories into one array
            foreach ($allSubdirFiles as $subdirFiles) {
                $allFiles = array_merge($allFiles, $subdirFiles);
            }
    
            sort($allFiles);
        }

        if ($onlyFiles) {
            return self::filterOnlyFiles($path, $allFiles);
        } elseif ($onlyDirs) {
            return self::filterOnlyDirs($path, $allFiles);
        } else {
            return $allFiles;
        }
    }

    /** Filter the given file array so that it only contains files */
    private static function filterOnlyFiles(string $path, array $files): array
    {
        return array_filter($files, fn($file) => !is_dir(Path::join($path, $file)));
    }

    /** Filter the given file array so that it only contains directories */
    private static function filterOnlyDirs(string $path, array $files): array
    {
        return array_filter($files, fn($file) => is_dir(Path::join($path, $file)));
    }

    /** Create the directory structure if it does not already exist */
    public static function mkdir(string $directory, bool $recursive = true): void
    {
        if (file_exists($directory)) {
            return;
        }
        
        mkdir($directory, recursive: $recursive);
    }
}
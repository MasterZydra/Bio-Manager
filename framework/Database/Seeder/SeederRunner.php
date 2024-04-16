<?php 

namespace Framework\Database\Seeder;

use Framework\Facades\File;
use Framework\Facades\Path;

class SeederRunner
{
    private string $seederPath = '';

    public function __construct()
    {
        $this->seederPath = Path::join(__DIR__, '..', '..', 'resources', 'Database', 'Seeders');
    }

    /** Apply all seeders */
    public function run(): void
    {
        $this->runAllSeeders(Path::join(__DIR__, 'Seeders'));
        $this->runAllSeeders($this->seederPath);
    }

    /** Run all the seeders */
    private function runAllSeeders(string $migrationsPath): void
    {
        $seederFiles = $this->getSeederFiles($migrationsPath);
        foreach ($seederFiles as $seederFile) {
            $this->runSeeder(Path::join($migrationsPath, $seederFile));
        }
    }

    /** Get all migration files from the migrations directory */
    private function getSeederFiles(string $seedersPath): array
    {
        $allFiles = File::findFilesInDir($seedersPath, onlyFiles: true);

        $seederFiles = [];
        /** @var string $file */
        foreach ($allFiles as $file) {
            if (!$this->isSeederFile($file)) {
                continue;
            }

            array_push($seederFiles, $file);
        }
        return $seederFiles;
    }

    private function isSeederFile(string $filename): bool
    {
        // Seeder files cannot start with a dot
        if (str_starts_with($filename, '.')) {
            return false;
        }
        // All seeder files must be PHP files
        if (!str_ends_with($filename, 'Seeder.php')) {
            return false;
        }
        // Only the default seeder is allowed
        if ($filename !== 'DatabaseSeeder.php') {
            return false;
        }
        return true;
    }

    /** Run the given seeder */
    private function runSeeder(string $filepath): void
    {
        /** @var SeederInterface $seeder */
        $seeder = require $filepath;
        $seeder->run();

        printLn('Applied ' . $this->extractSeederName($filepath));
    }

    /** Extract the seeder name out of the complete file path */
    private function extractSeederName(string $filepath): string
    {
        $path = explode(DIRECTORY_SEPARATOR, $filepath);
        return str_replace('.php', '', $path[count($path) - 1]);
    }
}

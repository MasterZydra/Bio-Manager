<?php

namespace Framework\Test;

use Framework\Facades\File;
use Framework\Facades\Path;

/** The TestRunner runs all test cases in the given test file path */
class TestRunner
{
    private string $testFilePath = '';

    public function __construct(?string $testFilePath = null) {
        if ($testFilePath !== null) {
            $this->testFilePath = $testFilePath;
        } else {
            $this->testFilePath = Path::join(__DIR__, '..', '..', 'resources', 'Tests');
        }
    }

    /** Run all tests in the given test file path */
    public function run(): bool
    {
        $GLOBALS['isTestRun'] = true;
        return $this->runUnitTests(Path::join(__DIR__, '..', 'resources', 'Tests'))
            && $this->runUnitTests($this->testFilePath);
    }

    /** Run all unit tests */
    private function runUnitTests(string $testFilePath): bool
    {
        $testFiles = $this->getUnitTestFiles($testFilePath);
        if (count($testFiles) === 0) {
            printLn('No unit test files found');
            return true;
        }

        printLn('Running unit tests...');
        $success = true;
        foreach ($testFiles as $testFile) {
            printLn('- ' . $testFile);
            if (!$this->runUnitTestFile($testFilePath, $testFile)) {
                $success = false;
            }
        }

        if ($success) {
            printLn('All tests were successful!');
        } else {
            printLn('One or more test case failed!');
        }
        printLn('');

        return $success;
    }

    /** Run all test methods in the given unit test file */
    private function runUnitTestFile(string $testFilePath, string $filepath): bool
    {
        $testCase = require Path::join($testFilePath, 'Unit', $filepath);
        $methods = get_class_methods($testCase);

        $success = true;
        /** @var string $method */
        foreach ($methods as $method) {
            if (!$this->isTestMethod($method)) {
                continue;
            }
            try {
                $testCase->$method();
            } catch (AssertionFailedException $ex) {
                printLn($ex->getTestCase() . ' failed:');
                printLn($ex->__toString());
                $success = false;
            } catch (\Throwable $th) {
                $success = false;
                throw $th;
            }

        }
        return $success;
    }

    /** Get array with all unit test files in the test file directory */
    private function getUnitTestFiles(string $testFilePath): array
    {
        $allFiles = File::findFilesInDir(Path::join($testFilePath, 'Unit'), recursive: true,  onlyFiles: true);

        $testFiles = [];
        /** @var string $file */
        foreach ($allFiles as $file) {
            if (!$this->isTestFile(basename($file))) {
                continue;
            }
            array_push($testFiles, $file);
        }
        return $testFiles;
    }

    private function isTestMethod(string $methodName): bool
    {
        // All test method must start with 'test'
        if (!str_starts_with($methodName, 'test')) {
            return false;
        }
        return true;
    }

    private function isTestFile(string $filename): bool
    {
        // All test files must start with 'Test'
        if (!str_starts_with($filename, 'Test')) {
            return false;
        }
        // All test files must be PHP files
        if (!str_ends_with($filename, '.php')) {
            return false;
        }
        return true;
    }
}

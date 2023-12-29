<?php

namespace Framework\Test;

/** The TestRunner runs all test cases in the given test file path */
class TestRunner
{
    private string $testFilePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'tests';

    public function __construct(string $testFilePath = null) {
        if ($testFilePath !== null) {
            $this->testFilePath = $testFilePath;
        }
    }

    /** Run all tests in the given test file path */
    public function run(): bool
    {
        return $this->runUnitTests();
    }

    /** Run all unit tests */
    private function runUnitTests(): bool
    {
        $testFiles = $this->getUnitTestFiles();
        if (count($testFiles) === 0) {
            echo 'No unit test files found' . PHP_EOL;
            return true;
        }

        $success = true;
        foreach ($testFiles as $testFile) {
            if (!$this->runUnitTestFile($testFile)) {
                $success = false;
            }
        }

        if ($success) {
            echo 'All tests were successful!' . PHP_EOL;
        } else {
            echo 'One or more test case failed!' . PHP_EOL;
        }

        return $success;
    }

    /** Run all test methods in the given unit test file */
    private function runUnitTestFile(string $filename): bool
    {
        require $this->testFilePath . DIRECTORY_SEPARATOR . 'Unit' . DIRECTORY_SEPARATOR . $filename;
        $testCaseName = str_replace('.php', '', $filename);
        $testCase = new $testCaseName();
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
                echo $ex->getTestCase() . ' failed:' . PHP_EOL;
                echo $ex->__toString() . PHP_EOL;
                $success = false;
            } catch (\Throwable $th) {
                $success = false;
                throw $th;
            }
            
        }
        return $success;
    }

    /** Get array with all unit test files in the test file directory */
    private function getUnitTestFiles(): array
    {
        $allFiles = scandir($this->testFilePath . DIRECTORY_SEPARATOR . 'Unit');
        if ($allFiles === false) {
            return [];
        }

        $testFiles = [];
        /** @var string $file */
        foreach ($allFiles as $file) {
            if (!$this->isTestFile($file)) {
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

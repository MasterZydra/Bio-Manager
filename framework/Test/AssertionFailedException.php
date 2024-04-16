<?php

namespace Framework\Test;

use Exception;

/** The AssertionFailedException is thrown if a assertion function in the `TestCase` failed. */
class AssertionFailedException extends Exception
{
    public function __construct(
        private string $expectedValue,
        private string $expectedType,
        private string $actualValue,
        private string $actualType,
    ) {
        parent::__construct();
    }

    public function __toString()
    {
        return 'Expected: "' . $this->expectedValue . '" (' . $this->expectedType . ')' . PHP_EOL .
            'Actual:   "' . $this->actualValue . '" (' . $this->actualType . ')' . PHP_EOL;
    }

    public function getTestCase(): string
    {
        return $this->getTrace()[1]['class'] . '->' . $this->getTrace()[1]['function'] . '()';
    }
}
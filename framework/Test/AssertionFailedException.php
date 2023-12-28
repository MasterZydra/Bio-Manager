<?php

namespace Framework\Test;

use Exception;

/** The AssertionFailedException is thrown if a assertion function in the `TestCase` failed. */
class AssertionFailedException extends Exception
{
    public function __construct(
        private string $expected,
        private string $got,
    ) {
        parent::__construct();
    }

    public function __toString()
    {
        return 'Expected: "' . $this->expected . '"' . PHP_EOL .
            'Got: "' . $this->got . '"' . PHP_EOL;
    }

    public function getTestCase(): string
    {
        return $this->getTrace()[1]['class'] . '->' . $this->getTrace()[1]['function'] . '()';
    }
}
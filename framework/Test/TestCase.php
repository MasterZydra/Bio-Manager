<?php

namespace Framework\Test;

use AssertionError;

/** Every unit test should base on this class. It provides the assertion functions. */
class TestCase
{
    public function assertTrue(bool $assertion): void
    {
        if (!$assertion) {
            throw new AssertionFailedException('true', $assertion ? 'true' : 'false');;
        }
    }

    public function assertEquals(mixed $expected, mixed $actual): void
    {
        if (gettype($expected) !== gettype($actual) || $expected !== $actual) {
            throw new AssertionFailedException($expected, $actual);
        }
    }
}
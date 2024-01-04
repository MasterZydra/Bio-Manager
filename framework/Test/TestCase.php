<?php

namespace Framework\Test;

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
        if (gettype($expected) !== gettype($actual)) {
            throw new AssertionFailedException($this->mixedToString($expected), $this->mixedToString($actual));
        }

        if (gettype($expected) === 'array') {
            if (json_encode($expected) === json_encode($actual)) {
                return;
            }
            throw new AssertionFailedException($this->mixedToString($expected), $this->mixedToString($actual));
        }

        if ($expected !== $actual) {
            throw new AssertionFailedException($this->mixedToString($expected), $this->mixedToString($actual));
        }
    }

    private function mixedToString(mixed $value): string
    {
        return match (gettype($value)) {
            'array' => json_encode($value),
            default => $value,
        };
    }
}
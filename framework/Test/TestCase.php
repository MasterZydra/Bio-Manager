<?php

namespace Framework\Test;

/** Every unit test should base on this class. It provides the assertion functions. */
class TestCase
{
    public function assertTrue(bool $assertion)
    {
        if (!$assertion) {
            throw new AssertionFailedException('true', $assertion ? 'true' : 'false');;
        }
    }
}
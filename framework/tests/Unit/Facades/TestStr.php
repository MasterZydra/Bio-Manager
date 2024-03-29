<?php

use Framework\Facades\Str;
use Framework\Test\TestCase;

class TestStr extends TestCase
{
    public function testRemoveLeadingLineSpaces(): void
    {
        $this->assertEquals(
            PHP_EOL . 'Hello World ' . PHP_EOL,
            Str::removeLeadingLineSpaces('  ' . PHP_EOL . ' Hello World ' . PHP_EOL)
        );

        $this->assertEquals(
            'Noting' . PHP_EOL . 'ToDo' . PHP_EOL . 'Here',
            Str::removeLeadingLineSpaces('Noting' . PHP_EOL . 'ToDo' . PHP_EOL . 'Here')
        );

    }
}
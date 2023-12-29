<?php

use Framework\Facades\Path;
use \Framework\Test\TestCase;

class TestPath extends TestCase
{
    public function testJoin()
    {
        $this->assertEquals(
            '/var/www/html/tests',
            Path::join('/var/', '/www', 'html\\', 'tests')
        );

        $this->assertEquals(
            '/var/testOne.php',
            Path::join('/var', 'testOne.php')
        );
    }
}
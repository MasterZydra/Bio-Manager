<?php

use Framework\Facades\Path;

return new class extends \Framework\Test\TestCase
{
    public function testJoin(): void
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
};

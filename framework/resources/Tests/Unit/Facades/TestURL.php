<?php

declare(strict_types = 1);

use Framework\Facades\URL;

return new class extends \Framework\Test\TestCase
{
    public function testJoin(): void
    {
        $this->assertEquals(
            'http://localhost/product/edit',
            URL::join('http://localhost/', '/product/edit/')
        );

        $this->assertEquals(
            '/product/edit',
            URL::join('/product/', '/edit')
        );
    }
};

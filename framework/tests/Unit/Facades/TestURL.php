<?php

use Framework\Facades\URL;
use Framework\Test\TestCase;

class TestURL extends TestCase
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
}
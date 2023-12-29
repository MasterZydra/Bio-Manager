<?php

use Framework\Facades\Convert;
use Framework\Test\TestCase;

class TestConvert extends TestCase
{
    public function testBoolToInt()
    {
        $this->assertEquals(1, Convert::boolToInt(true));
        $this->assertEquals(0, Convert::boolToInt(false));
    }
}

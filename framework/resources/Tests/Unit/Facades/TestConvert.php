<?php

declare(strict_types = 1);

use Framework\Facades\Convert;

return new class extends \Framework\Test\TestCase
{
    public function testBoolToInt(): void
    {
        $this->assertEquals(1, Convert::boolToInt(true));
        $this->assertEquals(0, Convert::boolToInt(false));
    }
};

<?php

use Framework\Message\Message;
use Framework\Message\Type;

return new class extends \Framework\Test\TestCase
{
    public function testSetMessage(): void
    {
        Message::setMessage('Test error message', Type::Error);
        $this->assertEquals([['message' => 'Test error message', 'type' => 'error']], Message::getMessages());

        Message::setMessage('Test warning message', Type::Warning);
        $this->assertEquals([['message' => 'Test warning message', 'type' => 'warning']], Message::getMessages());

        Message::setMessage('Test info message', Type::Info);
        $this->assertEquals([['message' => 'Test info message', 'type' => 'info']], Message::getMessages());

        Message::setMessage('Test success message', Type::Success);
        $this->assertEquals([['message' => 'Test success message', 'type' => 'success']], Message::getMessages());
    }
};

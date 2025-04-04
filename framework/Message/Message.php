<?php

declare(strict_types = 1);

namespace Framework\Message;

use Framework\Authentication\Session;

class Message
{
    private const MESSAGES = 'messages';

    public static function setMessage(string $message, Type $type): void
    {
        /** @var array $messages */
        $messages = Session::getValue(self::MESSAGES, []);
        $messages[] = ['message' => $message, 'type' => $type];
        Session::setValue(self::MESSAGES, $messages);
    }

    public static function getMessages(bool $clearMessages = true): array
    {
        $messages = Session::getValue(self::MESSAGES, []);
        if ($clearMessages) {
            Session::setValue(self::MESSAGES, []);
        }
        return $messages;
    }
}
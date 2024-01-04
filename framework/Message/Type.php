<?php

namespace Framework\Message;

enum Type: string
{
    case Error = 'error';
    case Warning = 'warning';
    case Info = 'info';
    case Success = 'success';
}

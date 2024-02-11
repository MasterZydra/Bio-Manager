<?php

namespace Framework\Database\Query;

enum ColType: string
{
    case Float = 'd';
    case Int = 'i';
    case Str = 's';
    case Null = 'null';
}
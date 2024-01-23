<?php

namespace Framework\Database;

enum ColumnType: string
{
    case Float = 'd';
    case Int = 'i';
    case Str = 's';
}
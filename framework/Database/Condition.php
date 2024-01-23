<?php

namespace Framework\Database;

enum Condition: string
{
    case Equal = '=';
    case Like = 'LIKE';
}
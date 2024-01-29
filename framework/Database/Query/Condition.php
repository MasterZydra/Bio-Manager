<?php

namespace Framework\Database\Query;

enum Condition: string
{
    case Equal = '=';
    case Like = 'LIKE';
}
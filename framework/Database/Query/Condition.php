<?php

namespace Framework\Database\Query;

enum Condition: string
{
    case Equal = '=';
    case Is = 'IS';
    case IsNot = 'IS NOT';
    case Like = 'LIKE';
}
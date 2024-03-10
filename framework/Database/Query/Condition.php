<?php

namespace Framework\Database\Query;

enum Condition: string
{
    case Equal = '=';
    case In = 'IN';
    case Is = 'IS';
    case IsNot = 'IS NOT';
    case Like = 'LIKE';
}
<?php

declare(strict_types = 1);

namespace Framework\Database\Query;

enum WhereCombine: string
{
    case And = 'AND';
    case Or = 'OR';
}
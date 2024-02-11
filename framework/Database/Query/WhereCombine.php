<?php

namespace Framework\Database\Query;

enum WhereCombine: string
{
    case And = 'AND';
    case Or = 'OR';
}
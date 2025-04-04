<?php

declare(strict_types = 1);

namespace Framework\Database\Query;

enum SortOrder: string
{
    case Asc = 'ASC';
    case Desc = 'DESC';
}
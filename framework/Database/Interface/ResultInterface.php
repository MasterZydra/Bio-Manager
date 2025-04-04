<?php

declare(strict_types = 1);

namespace Framework\Database\Interface;

interface ResultInterface
{
    public function fetch(): array|false;

    public function numRows(): int;
}
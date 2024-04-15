<?php

namespace Framework\Database;

interface ResultInterface
{
    public function fetch(): array|false;

    public function numRows(): int;
}
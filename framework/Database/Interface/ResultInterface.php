<?php

namespace Framework\Database\Interface;

interface ResultInterface
{
    public function fetch(): array|false;

    public function numRows(): int;
}
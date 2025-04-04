<?php

declare(strict_types = 1);

namespace Framework\Database\Interface;

interface BlueprintInterface
{
    public function build(): array;
}
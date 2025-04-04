<?php

declare(strict_types = 1);

namespace Framework\Database\Migration;

interface MigrationInterface
{
    /** This function is called to apply the migration */
    public function run(): void;
}
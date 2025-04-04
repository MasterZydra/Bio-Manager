<?php

declare(strict_types = 1);

namespace Framework\Database\Seeder;

interface SeederInterface
{
    /** This function is called to seed the table */
    public function run(): void;
}
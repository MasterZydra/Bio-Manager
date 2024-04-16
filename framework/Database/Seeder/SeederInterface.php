<?php

namespace Framework\Database\Seeder;

interface SeederInterface
{
    /** This function is called to seed the table */
    public function run(): void;
}
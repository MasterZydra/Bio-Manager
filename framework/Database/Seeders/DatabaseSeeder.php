<?php

use Framework\Database\Seeder;
use Framework\Database\SeederInterface;

return new class extends Seeder implements SeederInterface
{
    public function run(): void
    {
        // e.g. (new UserSeeder())->run();
    }
};

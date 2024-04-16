<?php

use Framework\Database\Seeder\Seeder;
use Framework\Database\Seeder\SeederInterface;

return new class extends Seeder implements SeederInterface
{
    public function run(): void
    {
        // e.g. (new UserSeeder())->run();
    }
};

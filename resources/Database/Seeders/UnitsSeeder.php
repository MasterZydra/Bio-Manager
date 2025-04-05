<?php

declare(strict_types = 1);

namespace Resources\Database\Seeders;

use App\Models\Setting;

class UnitsSeeder extends \Framework\Database\Seeder\Seeder implements \Framework\Database\Seeder\SeederInterface
{
    public function run(): void
    {
        new Setting()
            ->setName('massUnit')
            ->setDescription('Mass unit')
            ->setValue('kg')
            ->save();
        
        new Setting()
            ->setName('currencyUnit')
            ->setDescription('Currency unit')
            ->setValue('EUR')
            ->save();
    }
}

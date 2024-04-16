<?php

namespace Resources\Database\Seeders;

use App\Models\Setting;
use Framework\Database\Seeder\Seeder;
use Framework\Database\Seeder\SeederInterface;

class UnitsSeeder extends Seeder implements SeederInterface
{
    public function run(): void
    {
        (new Setting())
            ->setName('massUnit')
            ->setDescription('Mass unit')
            ->setValue('kg')
            ->save();
        
        (new Setting())
            ->setName('currencyUnit')
            ->setDescription('Currency unit')
            ->setValue('EUR')
            ->save();
    }
}

<?php

namespace Framework\Database\Seeders;

use App\Models\Setting;
use Framework\Database\Seeder;
use Framework\Database\SeederInterface;

class ImprintSettingsSeeder extends Seeder implements SeederInterface
{
    public function run(): void
    {
        // Provider
        (new Setting())
            ->setName('imprintProviderName')
            ->setDescription('Name of the provider of this website')
            ->setValue('Provider Name')
            ->save();
        
        (new Setting())
            ->setName('imprintProviderStreet')
            ->setDescription('Street of the provider of this website')
            ->setValue('Provider street')
            ->save();

        (new Setting())
            ->setName('imprintProviderPostalCode')
            ->setDescription('Postal code of the provider of this website')
            ->setValue('Provider postal code')
            ->save();
        
        (new Setting())
            ->setName('imprintProviderCity')
            ->setDescription('City of the provider of this website')
            ->setValue('Provider city')
            ->save();

        (new Setting())
            ->setName('imprintProviderEmail')
            ->setDescription('Email of the provider of this website')
            ->setValue('Provider email')
            ->save();
        
        // Responsible
        (new Setting())
            ->setName('imprintResponsibleName')
            ->setDescription('Name of the responsible of this website')
            ->setValue('Responsible Name')
            ->save();
        
        (new Setting())
            ->setName('imprintResponsibleStreet')
            ->setDescription('Street of the responsible of this website')
            ->setValue('Responsible street')
            ->save();

        (new Setting())
            ->setName('imprintResponsiblePostalCode')
            ->setDescription('Postal code of the responsible of this website')
            ->setValue('Responsible postal code')
            ->save();
        
        (new Setting())
            ->setName('imprintResponsibleCity')
            ->setDescription('City of the responsible of this website')
            ->setValue('Responsible city')
            ->save();

        (new Setting())
            ->setName('imprintResponsibleEmail')
            ->setDescription('Email of the responsible of this website')
            ->setValue('Responsible email')
            ->save();
    }
}
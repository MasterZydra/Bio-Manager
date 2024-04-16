<?php

namespace Framework\Database\Seeders;

use App\Models\Setting;
use Framework\Database\Seeder\Seeder;
use Framework\Database\Seeder\SeederInterface;

class InvoiceSettingsSeeder extends Seeder implements SeederInterface
{
    public function run(): void
    {
        // Invoice sender
        (new Setting())
            ->setName('invoiceSenderName')
            ->setDescription('Name of the invoice sender')
            ->setValue('Sender Name')
            ->save();
        
        (new Setting())
            ->setName('invoiceSenderStreet')
            ->setDescription('Street of the invoice sender')
            ->setValue('Sender street')
            ->save();

        (new Setting())
            ->setName('invoiceSenderPostalCode')
            ->setDescription('Postal code of the invoice sender')
            ->setValue('Sender postal code')
            ->save();
        
        (new Setting())
            ->setName('invoiceSenderCity')
            ->setDescription('City of the invoice sender')
            ->setValue('Sender city')
            ->save();

        (new Setting())
            ->setName('invoiceSenderAddition')
            ->setDescription('Address addition of the invoice sender')
            ->setValue('Address addition')
            ->save();

        // Bank information
        (new Setting())
            ->setName('invoiceBankName')
            ->setDescription('Invoice bank name')
            ->setValue('Invoice bank name')
            ->save();

        (new Setting())
            ->setName('invoiceIBAN')
            ->setDescription('Invoice IBAN')
            ->setValue('DEXX XXXX ...')
            ->save();
        
        (new Setting())
            ->setName('invoiceBIC')
            ->setDescription('Invoice BIC')
            ->setValue('GEXXXX...')
            ->save();

        // General information
        (new Setting())
            ->setName('invoiceAuthor')
            ->setDescription('Invoice author name')
            ->setValue('Invoice author name')
            ->save();

        (new Setting())
            ->setName('invoiceName')
            ->setDescription('Invoice name')
            ->setValue('Rechnung')
            ->save();
    }
}

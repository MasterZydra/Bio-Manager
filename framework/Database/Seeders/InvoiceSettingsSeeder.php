<?php

namespace Framework\Database\Seeders;

use App\Models\Setting;
use Framework\Database\Seeder;
use Framework\Database\SeederInterface;

class InvoiceSettingsSeeder extends Seeder implements SeederInterface
{
    public function run(): void
    {
        // Invoice
        (new Setting())
            ->setName('invoiceSender')
            ->setDescription('Invoice sender')
            ->setValue('Invoice sender name')
            ->save();
        
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

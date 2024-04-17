<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('invoices'))
            ->id()
            ->int('year')
            ->int('nr')
            ->date('invoiceDate', true)
            ->int('recipientId', foreignKey: ['recipients' => 'id'])
            ->bool('isPaid')
            ->timestamps()
        );
    }
};

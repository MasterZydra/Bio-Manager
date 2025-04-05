<?php

declare(strict_types = 1);

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        Database::executeBlueprint(new CreateTableBlueprint('invoices')
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

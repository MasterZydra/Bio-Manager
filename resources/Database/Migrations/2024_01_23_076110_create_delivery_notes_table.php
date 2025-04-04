<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('deliveryNotes'))
            ->id()
            ->int('year')
            ->int('nr')
            ->date('deliveryDate', true)
            ->float('amount', true)
            ->int('productId', foreignKey: ['products' => 'id'])
            ->int('supplierId', foreignKey: ['suppliers' => 'id'])
            ->int('recipientId', foreignKey: ['recipients' => 'id'])
            ->bool('isInvoiceReady')
            ->int('invoiceId', nullable: true, foreignKey: ['invoices' => 'id'])
            ->timestamps()
        );
    }
};
<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('volumeDistributions'))
            ->id()
            ->int('deliveryNoteId', foreignKey: ['deliveryNotes' => 'id'])
            ->int('plotId', foreignKey: ['plots' => 'id'])
            ->float('amount', true)
            ->timestamps()
        );
    }
};

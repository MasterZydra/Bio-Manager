<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
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

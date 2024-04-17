<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('prices'))
            ->id()
            ->int('year')
            ->float('price')
            ->float('pricePayout')
            ->int('productId', foreignKey: ['products' => 'id'])
            ->int('recipientId', foreignKey: ['recipients' => 'id'])
            ->timestamps()
        );
    }
};

<?php

use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;

return new class extends \Framework\Database\Migration\Migration
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

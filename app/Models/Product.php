<?php

declare(strict_types = 1);

namespace App\Models;

use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Facades\Convert;

class Product extends \Framework\Database\BaseModel
{
    private const NAME = 'name';
    private const IS_DISCONTINUED = 'isDiscontinued';

    public static array $orderBy = ['isDiscontinued' => 'asc', 'name' => 'asc'];

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function allowDelete(): bool
    {
        $deliveryNotes = DeliveryNote::all(
            DeliveryNote::getQueryBuilder()->where(ColType::Int, 'productId', Condition::Equal, $this->getId())
        );
        $prices = Price::all(
            Price::getQueryBuilder()->where(ColType::Int, 'productId', Condition::Equal, $this->getId())
        );

        return match (true) {
            count($deliveryNotes) > 0 => false,
            count($prices) > 0 => false,
            default => true,
        };
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (`name`, isDiscontinued) VALUES (?, ?)',
                'si',
                $this->getName(),
                Convert::boolToInt($this->getIsDiscontinued())
            );
        } else {
            $this->checkAllowEdit();
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `name`=?, isDiscontinued=? WHERE id=?',
                'sii',
                $this->getName(),
                Convert::boolToInt($this->getIsDiscontinued()),
                $this->getId()
            );
        }

        return $this;
    }

    /* Getter & Setter */

    public function getName(): string
    {
        return $this->getDataString(self::NAME);
    }

    public function setName(string $value): self
    {
        return $this->setDataString(self::NAME, $value);
    }

    public function getIsDiscontinued(): bool
    {
        return $this->getDataBool(self::IS_DISCONTINUED);
    }

    public function setIsDiscontinued(bool $value): self
    {
        return $this->setDataBool(self::IS_DISCONTINUED, $value);
    }
}
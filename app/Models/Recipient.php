<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Facades\Convert;

class Recipient extends BaseModel
{
    private const NAME = 'name';
    private const STREET = 'street';
    private const POSTAL_CODE = 'postalCode';
    private const CITY = 'city';
    private const IS_LOCKED = 'isLocked';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function allowDelete(): bool
    {
        $deliveryNotes = DeliveryNote::all(
            DeliveryNote::getQueryBuilder()->where(ColType::Int, 'recipientId', Condition::Equal, $this->getId())
        );
        $invoices = Invoice::all(
            Invoice::getQueryBuilder()->where(ColType::Int, 'recipientId', Condition::Equal, $this->getId())
        );
        $prices = Price::all(
            Price::getQueryBuilder()->where(ColType::Int, 'recipientId', Condition::Equal, $this->getId())
        );

        return match (true) {
            count($deliveryNotes) > 0 => false,
            count($invoices) > 0 => false,
            count($prices) > 0 => false,
            default => true,
        };
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (name, street, postalCode, city, isLocked) VALUES (?, ?, ?, ?, ?)',
                'ssssi',
                $this->getName(),
                $this->getStreet(),
                $this->getPostalCode(),
                $this->getCity(),
                Convert::boolToInt($this->getIsLocked())
            );
        } else {
            $this->checkAllowEdit();
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `name`=?, street=?, postalCode=?, city=?, isLocked=? WHERE id=?',
                'ssssii',
                $this->getName(),
                $this->getStreet(),
                $this->getPostalCode(),
                $this->getCity(),
                Convert::boolToInt($this->getIsLocked()),
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

    public function getStreet(): string
    {
        return $this->getDataString(self::STREET);
    }

    public function setStreet(string $value): self
    {
        return $this->setDataString(self::STREET, $value);
    }

    public function getPostalCode(): string
    {
        return $this->getDataString(self::POSTAL_CODE);
    }

    public function setPostalCode(string $value): self
    {
        return $this->setDataString(self::POSTAL_CODE, $value);
    }

    public function getCity(): string
    {
        return $this->getDataString(self::CITY);
    }

    public function setCity(string $value): self
    {
        return $this->setDataString(self::CITY, $value);
    }

    public function getIsLocked(): bool
    {
        return $this->getDataBool(self::IS_LOCKED);
    }

    public function setIsLocked(bool $value): self
    {
        return $this->setDataBool(self::IS_LOCKED, $value);
    }
}

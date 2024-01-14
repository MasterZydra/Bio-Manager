<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Facades\Convert;

class Recipient extends BaseModel
{
    private const NAME = 'name';
    private const ADDRESS = 'address';
    private const IS_LOCKED = 'isLocked';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (name, address, isLocked) VALUES (?, ?, ?)',
                'ssi',
                $this->getName(),
                $this->getAddress(),
                Convert::boolToInt($this->getIsLocked())
            );
        } else {
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `name`=?, address=?, isLocked=? WHERE id=?',
                'ssii',
                $this->getName(),
                $this->getAddress(),
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

    public function getAddress(): string
    {
        return $this->getDataString(self::ADDRESS);
    }

    public function setAddress(string $value): self
    {
        return $this->setDataString(self::ADDRESS, $value);
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

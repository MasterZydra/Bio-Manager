<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Facades\Convert;

class Plot extends BaseModel
{
    private const NR = 'nr';
    private const NAME = 'name';
    private const SUBDISTRICT = 'subdistrict';
    private const SUPPLIER_ID = 'supplierId';
    private const IS_LOCKED = 'isLocked';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (nr, name, subdistrict, supplierId, isLocked) VALUES (?, ?, ?, ?, ?)',
                'sssii',
                $this->getNr(),
                $this->getName(),
                $this->getSubdistrict(),
                $this->getSupplierId(),
                Convert::boolToInt($this->getIsLocked())
            );
        } else {
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET nr=?, name=?, subdistrict=?, supplierId=?, isLocked=? WHERE id=?',
                'sssiii',
                $this->getNr(),
                $this->getName(),
                $this->getSubdistrict(),
                $this->getSupplierId(),
                Convert::boolToInt($this->getIsLocked()),
                $this->getId()
            );
        }

        return $this;
    }

    public function getSupplier(): Supplier
    {
        return Supplier::findById($this->getSupplierId());
    }

    /* Getter & Setter */

    public function getNr(): string
    {
        return $this->getDataString(self::NR);
    }

    public function setNr(string $value): self
    {
        return $this->setDataString(self::NR, $value);
    }

    public function getName(): string
    {
        return $this->getDataString(self::NAME);
    }

    public function setName(string $value): self
    {
        return $this->setDataString(self::NAME, $value);
    }

    public function getSubdistrict(): string
    {
        return $this->getDataString(self::SUBDISTRICT);
    }

    public function setSubdistrict(string $value): self
    {
        return $this->setDataString(self::SUBDISTRICT, $value);
    }

    public function getSupplierId(): int
    {
        return $this->getDataInt(self::SUPPLIER_ID);
    }

    public function setSupplierId(int $value): self
    {
        return $this->setDataInt(self::SUPPLIER_ID, $value);
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

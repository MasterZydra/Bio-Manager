<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Facades\Convert;

class Product extends BaseModel
{
    private const NAME = 'name';
    private const IS_DISCONTINUED = 'isDiscontinued';

    protected static function new(array $data = []): self
    {
        return new self($data);
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
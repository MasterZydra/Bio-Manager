<?php

namespace App\Models;

use Framework\Database\Database;
use Framework\Database\BaseModel;

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
                'INSERT INTO products (`name`, isDiscontinued) VALUES (?, ?)',
                'si',
                $this->getName(),
                ($this->getIsDiscontinued() ? 1 : 0)
            );
        } else {
            Database::prepared(
                'UPDATE products SET `name`= ?, isDiscontinued=? WHERE id=?',
                'sii',
                $this->getName(),
                ($this->getIsDiscontinued() ? 1 : 0),
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
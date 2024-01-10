<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;

class Role extends BaseModel
{
    private const NAME = 'name';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (`name`) VALUES (?)',
                's',
                $this->getName()
            );
        } else {
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `name`=? WHERE id=?',
                'si',
                $this->getName(),
                $this->getId()
            );
        }

        return $this;
    }

    public static function findByName(string $name): self
    {
        $dataSet = Database::prepared('SELECT * FROM ' . self::getTableName() . ' WHERE name=?', 's', $name);
        if ($dataSet === false || $dataSet->num_rows !== 1) {
            return new self();
        }

        return new self($dataSet->fetch_assoc());
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
}

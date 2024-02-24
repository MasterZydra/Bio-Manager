<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;

class Setting extends BaseModel
{
    private const NAME = 'name';
    private const DESCRIPTION = 'description';
    private const VALUE = 'value';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (`name`, description, value) VALUES (?, ?, ?)',
                'sss',
                $this->getName(),
                $this->getDescription(),
                $this->getValue()
            );
        } else {
            $this->checkAllowEdit();
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `name`=?, description=?, value=? WHERE id=?',
                'sssi',
                $this->getName(),
                $this->getDescription(),
                $this->getValue(),
                $this->getId()
            );
        }

        return $this;
    }

    public static function findByName(string $name): self
    {
        return self::find(self::getQueryBuilder()->where(ColType::Str, 'name', Condition::Equal, $name));
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

    public function getDescription(): string
    {
        return $this->getDataString(self::DESCRIPTION);
    }

    public function setDescription(string $value): self
    {
        return $this->setDataString(self::DESCRIPTION, $value);
    }

    public function getValue(): string
    {
        return $this->getDataString(self::VALUE);
    }

    public function setValue(string $value): self
    {
        return $this->setDataString(self::VALUE, $value);
    }
}

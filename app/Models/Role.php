<?php

namespace App\Models;

use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;

class Role extends \Framework\Database\BaseModel
{
    private const NAME = 'name';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function allowDelete(): bool
    {
        $userRoles = UserRole::all(
            UserRole::getQueryBuilder()->where(ColType::Int, 'roleId', Condition::Equal, $this->getId())
        );

        return match (true) {
            count($userRoles) > 0 => false,
            default => true,
        };
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
            $this->checkAllowEdit();
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
}

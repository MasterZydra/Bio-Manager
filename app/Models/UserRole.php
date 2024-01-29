<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;

class UserRole extends BaseModel
{
    private const USER_ID = 'userId';
    private const ROLE_ID = 'roleId';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (userId, roleId) VALUES (?, ?)',
                'ii',
                $this->getUserId(),
                $this->getRoleId()
            );
        } else {
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET userId=?, roleId=? WHERE id=?',
                'iii',
                $this->getUserId(),
                $this->getRoleId(),
                $this->getId()
            );
        }

        return $this;
    }

    public static function findByUserAndRoleId(int $userId, int $roleId): self
    {
        return self::find(self::getQueryBuilder()
            ->where(ColType::Int, 'userId', Condition::Equal, $userId)
            ->where(ColType::Int, 'roleId', Condition::Equal, $roleId)
        );
    }

    /* Getter & Setter */

    public function getUserId(): int
    {
        return $this->getDataInt(self::USER_ID);
    }

    public function setUserId(int $value): self
    {
        return $this->setDataInt(self::USER_ID, $value);
    }

    public function getRoleId(): int
    {
        return $this->getDataInt(self::ROLE_ID);
    }

    public function setRoleId(int $value): self
    {
        return $this->setDataInt(self::ROLE_ID, $value);
    }
}

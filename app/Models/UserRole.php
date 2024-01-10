<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;

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
        $dataSet = Database::prepared(
            'SELECT * FROM ' . self::getTableName() . ' WHERE userId=? and roleId=?',
            'ii',
            $userId,
            $roleId
        );
        if ($dataSet === false || $dataSet->num_rows !== 1) {
            return new self();
        }

        return new self($dataSet->fetch_assoc());
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

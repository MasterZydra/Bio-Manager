<?php

namespace App\Models;

use Framework\Authentication\Auth;
use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Facades\Convert;

class User extends BaseModel
{
    private const FIRSTNAME = 'firstname';
    private const LASTNAME = 'lastname';
    private const USERNAME = 'username';
    private const PASSWORD = 'password';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (firstname, lastname, username, password, isLocked, isPwdChangeForced) VALUES (?, ?, ?, ?, ?, ?)',
                'ssssii',
                $this->getFirstname(),
                $this->getLastname(),
                $this->getUsername(),
                $this->getPassword(),
                Convert::boolToInt($this->getIsLocked()),
                Convert::boolToInt($this->getIsPwdChangeForced())
            );
        } else {
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET firstname=?, lastname=?, username=?, password=?, isLocked=?, isPwdChangeForced=? WHERE id=?',
                'ssssiii',
                $this->getFirstname(),
                $this->getLastname(),
                $this->getUsername(),
                $this->getPassword(),
                Convert::boolToInt($this->getIsLocked()),
                Convert::boolToInt($this->getIsPwdChangeForced()),
                $this->getId()
            );
        }

        return $this;
    }

    public static function findByUsername(string $username): self
    {
        $dataSet = Database::prepared('SELECT * FROM users WHERE username = ?', 's', $username);
        if ($dataSet === false || $dataSet->num_rows !== 1) {
            return new self();
        }

        return new self($dataSet->fetch_assoc());
    }

    /* Getter & Setter */

    public function getFirstname(): string
    {
        return $this->getDataString(self::FIRSTNAME);
    }

    public function setFirstname(string $value): self
    {
        return $this->setDataString(self::FIRSTNAME, $value);
    }

    public function getLastname(): string
    {
        return $this->getDataString(self::LASTNAME);
    }

    public function setLastname(string $value): self
    {
        return $this->setDataString(self::LASTNAME, $value);
    }

    public function getUsername(): string
    {
        return $this->getDataString(self::USERNAME);
    }

    public function setUsername(string $value): self
    {
        return $this->setDataString(self::USERNAME, $value);
    }

    public function getPassword(): ?string
    {
        return $this->getDataStringOrNull(self::PASSWORD);
    }

    public function setPassword(?string $value): self
    {
        return $this->setDataStringOrNull(self::PASSWORD, Auth::hashPassword($value));
    }

    // TODO create missing getter and setter
    /* 
            'isLocked tinyint(1) NOT NULL DEFAULT 0,' .
            'IsPwdChangeForced
         */
}

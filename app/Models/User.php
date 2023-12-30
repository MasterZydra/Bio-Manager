<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Facades\Convert;

class User extends BaseModel
{
    private const FIRSTNAME = 'firstname';
    private const LASTNAME = 'lastname';
    private const USERNAME = 'username';

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

    // TODO create missing getter and setter
    /* 
            'password VARCHAR(255) NULL,' .
            'isLocked tinyint(1) NOT NULL DEFAULT 0,' .
            'IsPwdChangeForced
         */
}

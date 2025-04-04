<?php

declare(strict_types = 1);

namespace App\Models;

use Framework\Authentication\Auth;
use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Facades\Convert;

class User extends \Framework\Database\BaseModel
{
    private const FIRSTNAME = 'firstname';
    private const LASTNAME = 'lastname';
    private const USERNAME = 'username';
    private const PASSWORD = 'password';
    private const IS_LOCKED = 'isLocked';
    private const IS_PWD_CHANGE_FORCED = 'isPwdChangeForced';
    private const LANGUAGE_ID = 'languageId';

    public static array $orderBy = ['isLocked' => 'asc', 'username' => 'asc'];

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function allowDelete(): bool
    {
        $userRoles = UserRole::all(
            UserRole::getQueryBuilder()->where(ColType::Int, 'userId', Condition::Equal, $this->getId())
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
                'INSERT INTO ' . $this->getTableName() . ' (firstname, lastname, username, password, isLocked, isPwdChangeForced, languageId) VALUES (?, ?, ?, ?, ?, ?, ?)',
                'ssssiii',
                $this->getFirstname(),
                $this->getLastname(),
                $this->getUsername(),
                $this->getPassword(),
                Convert::boolToInt($this->getIsLocked()),
                Convert::boolToInt($this->getIsPwdChangeForced()),
                $this->getLanguageId()
            );
        } else {
            $this->checkAllowEdit();
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET firstname=?, lastname=?, username=?, password=?, isLocked=?, isPwdChangeForced=?, languageId=? WHERE id=?',
                'ssssiiii',
                $this->getFirstname(),
                $this->getLastname(),
                $this->getUsername(),
                $this->getPassword(),
                Convert::boolToInt($this->getIsLocked()),
                Convert::boolToInt($this->getIsPwdChangeForced()),
                $this->getLanguageId(),
                $this->getId()
            );
        }

        return $this;
    }

    public static function findByUsername(string $username): self
    {
        return self::find(self::getQueryBuilder()->where(ColType::Str, 'username', Condition::Equal, $username));
    }

    public function canLogIn(): bool
    {
        return $this->getId() !== null && !$this->getIsLocked();
    }

    public function getLanguage(): Language
    {
        return Language::findById($this->getLanguageId());
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

    public function getIsLocked(): bool
    {
        return $this->getDataBool(self::IS_LOCKED);
    }

    public function setIsLocked(bool $value): self
    {
        return $this->setDataBool(self::IS_LOCKED, $value);
    }

    public function getIsPwdChangeForced(): bool
    {
        return $this->getDataBool(self::IS_PWD_CHANGE_FORCED);
    }

    public function setIsPwdChangeForced(bool $value): self
    {
        return $this->setDataBool(self::IS_PWD_CHANGE_FORCED, $value);
    }

    public function getLanguageId(): ?int
    {
        return $this->getDataIntOrNull(self::LANGUAGE_ID);
    }

    public function setLanguageId(?int $value): self
    {
        return $this->setDataIntOrNull(self::LANGUAGE_ID, $value);
    }
}

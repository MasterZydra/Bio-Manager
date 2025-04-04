<?php

namespace App\Models;

use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;

class Language extends \Framework\Database\BaseModel
{
    private const CODE = 'code';
    private const NAME = 'name';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function allowDelete(): bool
    {
        $users = User::all(
            User::getQueryBuilder()->where(ColType::Int, 'languageId', Condition::Equal, $this->getId())
        );

        return match (true) {
            count($users) > 0 => false,
            default => true,
        };
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (code, `name`) VALUES (?, ?)',
                'ss',
                $this->getCode(),
                $this->getName()
            );
        } else {
            $this->checkAllowEdit();
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET code=?, `name`=? WHERE id=?',
                'ssi',
                $this->getCode(),
                $this->getName(),
                $this->getId()
            );
        }

        return $this;
    }

    /* Getter & Setter */

    public function getCode(): string
    {
        return $this->getDataString(self::CODE);
    }

    public function setCode(string $value): self
    {
        return $this->setDataString(self::CODE, $value);
    }

    public function getName(): string
    {
        return $this->getDataString(self::NAME);
    }

    public function setName(string $value): self
    {
        return $this->setDataString(self::NAME, $value);
    }
}

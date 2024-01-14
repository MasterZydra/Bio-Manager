<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Facades\Convert;

class Supplier extends BaseModel
{
    private const NAME = 'name';
    private const IS_LOCKED = 'isLocked';
    private const HAS_FULL_PAYOUT = 'hasFullPayout';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (name, isLocked) VALUES (?, ?, ?)',
                'sii',
                $this->getName(),
                Convert::boolToInt($this->getIsLocked()),
                Convert::boolToInt($this->getHasFullPayout())
            );
        } else {
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `name`=?, isLocked=?, hasFullPayout=? WHERE id=?',
                'siii',
                $this->getName(),
                Convert::boolToInt($this->getIsLocked()),
                Convert::boolToInt($this->getHasFullPayout()),
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

    public function getIsLocked(): bool
    {
        return $this->getDataBool(self::IS_LOCKED);
    }

    public function setIsLocked(bool $value): self
    {
        return $this->setDataBool(self::IS_LOCKED, $value);
    }

    public function getHasFullPayout(): bool
    {
        return $this->getDataBool(self::HAS_FULL_PAYOUT);
    }

    public function setHasFullPayout(bool $value): self
    {
        return $this->setDataBool(self::HAS_FULL_PAYOUT, $value);
    }
}

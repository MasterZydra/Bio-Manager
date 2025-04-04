<?php

declare(strict_types = 1);

namespace App\Models;

use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Facades\Convert;

class Supplier extends \Framework\Database\BaseModel
{
    private const NAME = 'name';
    private const IS_LOCKED = 'isLocked';
    private const HAS_FULL_PAYOUT = 'hasFullPayout';
    private const HAS_NO_PAYOUT = 'hasNoPayout';

    public static array $orderBy = ['isLocked' => 'asc', 'name' => 'asc'];

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function allowDelete(): bool
    {
        $deliveryNotes = DeliveryNote::all(
            DeliveryNote::getQueryBuilder()->where(ColType::Int, 'supplierId', Condition::Equal, $this->getId())
        );
        $plots = Plot::all(
            Plot::getQueryBuilder()->where(ColType::Int, 'supplierId', Condition::Equal, $this->getId())
        );

        return match (true) {
            count($deliveryNotes) > 0 => false,
            count($plots) > 0 => false,
            default => true,
        };
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (name, isLocked, hasFullPayout, hasNoPayout) VALUES (?, ?, ?, ?)',
                'siii',
                $this->getName(),
                Convert::boolToInt($this->getIsLocked()),
                Convert::boolToInt($this->getHasFullPayout()),
                Convert::boolToInt($this->getHasNoPayout())
            );
        } else {
            $this->checkAllowEdit();
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `name`=?, isLocked=?, hasFullPayout=?, hasNoPayout=? WHERE id=?',
                'siiii',
                $this->getName(),
                Convert::boolToInt($this->getIsLocked()),
                Convert::boolToInt($this->getHasFullPayout()),
                Convert::boolToInt($this->getHasNoPayout()),
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

    public function getHasNoPayout(): bool
    {
        return $this->getDataBool(self::HAS_NO_PAYOUT);
    }

    public function setHasNoPayout(bool $value): self
    {
        return $this->setDataBool(self::HAS_NO_PAYOUT, $value);
    }
}

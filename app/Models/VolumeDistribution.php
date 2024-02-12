<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;

class VolumeDistribution extends BaseModel
{
    private const DELIVERY_NOTE_ID = 'deliveryNoteId';
    private const PLOT_ID = 'plotId';
    private const AMOUNT = 'amount';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (deliveryNoteId, plotId, amount) VALUES (?, ?, ?)',
                'iid',
                $this->getDeliveryNoteId(),
                $this->getPlotId(),
                $this->getAmount()
            );
        } else {
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET deliveryNoteId=?, plotId=?, amount=? WHERE id=?',
                'iidi',
                $this->getDeliveryNoteId(),
                $this->getPlotId(),
                $this->getAmount(),
                $this->getId()
            );
        }

        return $this;
    }

    public static function allByDeliveryNoteId(int $deliveryNoteId): array
    {
        return self::all(self::getQueryBuilder()->where(ColType::Int, 'deliveryNoteId', Condition::Equal, $deliveryNoteId));
    }

    public function getDeliveryNote(): DeliveryNote
    {
        return DeliveryNote::findById($this->getDeliveryNoteId());
    }

    public function getPlot(): Plot
    {
        return Plot::findById($this->getPlotId());
    }

    /* Getter & Setter */

    public function getDeliveryNoteId(): int
    {
        return $this->getDataInt(self::DELIVERY_NOTE_ID);
    }

    public function setDeliveryNoteId(int $value): self
    {
        return $this->setDataInt(self::DELIVERY_NOTE_ID, $value);
    }

    public function getPlotId(): int
    {
        return $this->getDataInt(self::PLOT_ID);
    }

    public function setPlotId(int $value): self
    {
        return $this->setDataInt(self::PLOT_ID, $value);
    }

    public function getAmount(): ?float
    {
        return $this->getDataFloatOrNull(self::AMOUNT);
    }

    public function setAmount(?float $value): self
    {
        return $this->setDataFloatOrNull(self::AMOUNT, $value);
    }
}

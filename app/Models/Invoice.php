<?php

declare(strict_types = 1);

namespace App\Models;

use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Database\Query\QueryBuilder;
use Framework\Facades\Convert;

class Invoice extends \Framework\Database\BaseModel
{
    private const YEAR = 'year';
    private const NR = 'nr';
    private const INVOICE_DATE = 'invoiceDate';
    private const RECIPIENT_ID = 'recipientId';
    private const IS_PAID = 'isPaid';

    public static array $orderBy = ['year' => 'desc', 'nr' => 'desc'];

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function allowEdit(): bool
    {
        $before = Invoice::findById($this->getId());

        return match (true) {
            $before->getIsPaid() => false,
            default => true,
        };
    }

    public function allowDelete(): bool
    {
        return match (true) {
            $this->getIsPaid() => false,
            default => true,
        };
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (`year`, nr, invoiceDate, recipientId, isPaid) VALUES (?, ?, ?, ?, ?)',
                'iisii',
                $this->getYear(),
                $this->getNr(),
                $this->getInvoiceDate(),
                $this->getRecipientId(),
                Convert::boolToInt($this->getIsPaid())
            );
        } else {
            $this->checkAllowEdit();
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `year`=?, nr=?, invoiceDate=?, recipientId=?, isPaid=? WHERE id=?',
                'iisiii',
                $this->getYear(),
                $this->getNr(),
                $this->getInvoiceDate(),
                $this->getRecipientId(),
                Convert::boolToInt($this->getIsPaid()),
                $this->getId()
            );
        }

        return $this;
    }

    public static function findByYearAndNr(int $year, int $nr): self
    {
        return self::find(self::getQueryBuilder()
            ->where(ColType::Int, 'year', Condition::Equal, $year)
            ->where(ColType::Int, 'nr', Condition::Equal, $nr));
    }

    public function getRecipient(): Recipient
    {
        return Recipient::findById($this->getRecipientId());
    }

    public static function nextInvoiceNr(?int $year = null): int
    {
        if ($year === null) {
            $year = intval(date('Y'));
        }

        $dataSet = Database::executeBuilder(
            QueryBuilder::new(self::getTableName())
                ->select('MAX(nr) + 1 AS nextId')
                ->where(ColType::Int, 'year', Condition::Equal, $year)
        );
        if ($dataSet === false || $dataSet->numRows() !== 1) {
            return 1;
        }
        $row = $dataSet->fetch();
        if ($row['nextId'] === null) {
            return 1;
        }
        return $row['nextId'];
    }

    public function getDeliveryNotes(): array
    {
        return DeliveryNote::all(DeliveryNote::getQueryBuilder()
            ->where(ColType::Int, 'invoiceId', Condition::Equal, $this->getId())
            ->orderBy('nr')
        );
    }

    public function getTotalPrice(): float
    {
        $total = 0.0;
        /** @var \App\Models\DeliveryNote $deliveryNote */
        foreach ($this->getDeliveryNotes() as $deliveryNote) {
            $total += $deliveryNote->getPositionPrice();
        }
        return $total;
    }

    /* Helper for PDF */

    public function PdfInvoiceName(): string
    {
        return implode('_', [setting('invoiceName'), $this->getYear(), $this->getNr()]);
    }

    /* Getter & Setter */

    public function getYear(): int
    {
        return $this->getDataInt(self::YEAR);
    }

    public function setYear(int $value): self
    {
        return $this->setDataInt(self::YEAR, $value);
    }

    public function getNr(): int
    {
        return $this->getDataInt(self::NR);
    }

    public function setNr(int $value): self
    {
        return $this->setDataInt(self::NR, $value);
    }

    public function getInvoiceDate(): string
    {
        return $this->getDataString(self::INVOICE_DATE);
    }

    public function setInvoiceDate(string $value): self
    {
        return $this->setDataString(self::INVOICE_DATE, $value);
    }

    public function getRecipientId(): int
    {
        return $this->getDataInt(self::RECIPIENT_ID);
    }

    public function setRecipientId(int $value): self
    {
        return $this->setDataInt(self::RECIPIENT_ID, $value);
    }

    public function getIsPaid(): bool
    {
        return $this->getDataBool(self::IS_PAID);
    }

    public function setIsPaid(bool $value): self
    {
        return $this->setDataBool(self::IS_PAID, $value);
    }

}

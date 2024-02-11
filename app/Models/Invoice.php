<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Database\QueryBuilder;
use Framework\Facades\Convert;

class Invoice extends BaseModel
{
    private const YEAR = 'year';
    private const NR = 'nr';
    private const INVOICE_DATE = 'invoiceDate';
    private const RECIPIENT_ID = 'recipientId';
    private const IS_PAID = 'isPaid';

    protected static function new(array $data = []): self
    {
        return new self($data);
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

    public static function nextInvoiceNr(int $year = null): int
    {
        if ($year === null) {
            $year = intval(date('Y'));
        }

        $dataSet = Database::executeBuilder(
            QueryBuilder::new(self::getTableName())
                ->select('MAX(nr) + 1 AS nextId')
                ->where(ColType::Int, 'year', Condition::Equal, $year)
        );
        if ($dataSet === false || $dataSet->num_rows !== 1) {
            return 1;
        }
        $row = $dataSet->fetch_assoc();
        if ($row['nextId'] === null) {
            return 1;
        }
        return $row['nextId'];
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

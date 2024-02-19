<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;
use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Database\Query\WhereCombine;
use Framework\Database\QueryBuilder;
use Framework\Facades\Convert;

class DeliveryNote extends BaseModel
{
    private const YEAR = 'year';
    private const NR = 'nr';
    private const DELIVERY_DATE = 'deliveryDate';
    private const AMOUNT = 'amount';
    private const PRODUCT_ID = 'productId';
    private const SUPPLIER_ID = 'supplierId';
    private const RECIPIENT_ID = 'recipientId';
    private const IS_INVOICE_READY = 'isInvoiceReady';
    private const INVOICE_ID = 'invoiceId';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (`year`, nr, deliveryDate, amount, productId, supplierId, recipientId, isInvoiceReady, invoiceId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
                'iisdiiiii',
                $this->getYear(),
                $this->getNr(),
                $this->getDeliveryDate(),
                $this->getAmount(),
                $this->getProductId(),
                $this->getSupplierId(),
                $this->getRecipientId(),
                Convert::boolToInt($this->getIsInvoiceReady()),
                $this->getInvoiceId()
            );
        } else {
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `year`=?, nr=?, deliveryDate=?, amount=?, productId=?, supplierId=?, recipientId=?, isInvoiceReady=?, invoiceId=? WHERE id=?',
                'iisdiiiiii',
                $this->getYear(),
                $this->getNr(),
                $this->getDeliveryDate(),
                $this->getAmount(),
                $this->getProductId(),
                $this->getSupplierId(),
                $this->getRecipientId(),
                Convert::boolToInt($this->getIsInvoiceReady()),
                $this->getInvoiceId(),
                $this->getId()
            );
        }

        return $this;
    }

    public static function allReadyForInvoice(Invoice $invoice): array
    {
        return self::all(
            self::getQueryBuilder()
            ->where(ColType::Int, 'isInvoiceReady', Condition::Equal, 1)
            ->where(ColType::Int, 'year', Condition::Equal, $invoice->getYear())
            ->where(ColType::Int, 'recipientId', Condition::Equal, $invoice->getRecipientId())
            ->where(ColType::Null, 'invoiceId', Condition::Is, null)
            ->where(ColType::Int, 'invoiceId', Condition::Equal, $invoice->getId(), WhereCombine::Or)
            ->orderBy('nr')
        );
    }

    public function getPositionPrice(): float
    {
        return $this->getAmount() * $this->getPrice()->getPrice();
    }

    public function getPrice(): Price
    {
        return Price::find(Price::getQueryBuilder()
            ->where(ColType::Int, 'year', Condition::Equal, $this->getYear())
            ->where(ColType::Int, 'productId', Condition::Equal, $this->getProductId())
            ->where(ColType::Int, 'recipientId', Condition::Equal, $this->getRecipientId())
        );
    }

    public function getProduct(): Product
    {
        return Product::findById($this->getProductId());
    }

    public function getSupplier(): Supplier
    {
        return Supplier::findById($this->getSupplierId());
    }

    public function getRecipient(): Recipient
    {
        return Recipient::findById($this->getRecipientId());
    }

    public static function nextDeliveryNoteNr(int $year = null): int
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

    public function getDeliveryDate(): string
    {
        return $this->getDataString(self::DELIVERY_DATE);
    }

    public function setDeliveryDate(string $value): self
    {
        return $this->setDataString(self::DELIVERY_DATE, $value);
    }

    public function getAmount(): ?float
    {
        return $this->getDataFloatOrNull(self::AMOUNT);
    }

    public function setAmount(?float $value): self
    {
        return $this->setDataFloatOrNull(self::AMOUNT, $value);
    }

    public function getProductId(): int
    {
        return $this->getDataInt(self::PRODUCT_ID);
    }

    public function setProductId(int $value): self
    {
        return $this->setDataInt(self::PRODUCT_ID, $value);
    }

    public function getSupplierId(): int
    {
        return $this->getDataInt(self::SUPPLIER_ID);
    }

    public function setSupplierId(int $value): self
    {
        return $this->setDataInt(self::SUPPLIER_ID, $value);
    }

    public function getRecipientId(): int
    {
        return $this->getDataInt(self::RECIPIENT_ID);
    }

    public function setRecipientId(int $value): self
    {
        return $this->setDataInt(self::RECIPIENT_ID, $value);
    }

    public function getIsInvoiceReady(): bool
    {
        return $this->getDataBool(self::IS_INVOICE_READY);
    }

    public function setIsInvoiceReady(bool $value): self
    {
        return $this->setDataBool(self::IS_INVOICE_READY, $value);
    }

    public function getInvoiceId(): ?int
    {
        return $this->getDataIntOrNull(self::INVOICE_ID);
    }

    public function setInvoiceId(?int $value): self
    {
        return $this->setDataIntOrNull(self::INVOICE_ID, $value);
    }
}

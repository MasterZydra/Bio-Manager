<?php

namespace App\Models;

use Framework\Database\BaseModel;
use Framework\Database\Database;

class Price extends BaseModel
{
    private const YEAR = 'year';
    private const PRICE = 'price';
    private const PRICE_PAYOUT = 'pricePayout';
    private const PRODUCT_ID = 'productId';
    private const RECIPIENT_ID = 'recipientId';

    protected static function new(array $data = []): self
    {
        return new self($data);
    }

    public function save(): self
    {
        if ($this->getId() === null) {
            Database::prepared(
                'INSERT INTO ' . $this->getTableName() . ' (`year`, price, pricePayout, productId, recipientId) VALUES (?, ?, ?, ?, ?)',
                'iddii',
                $this->getYear(),
                $this->getPrice(),
                $this->getPricePayout(),
                $this->getProductId(),
                $this->getRecipientId()
            );
        } else {
            Database::prepared(
                'UPDATE ' . $this->getTableName() . ' SET `year` = ?, price = ?, pricePayout = ?, productId = ?, recipientId = ? WHERE id = ?',
                'iddiii',
                $this->getYear(),
                $this->getPrice(),
                $this->getPricePayout(),
                $this->getProductId(),
                $this->getRecipientId(),
                $this->getId()
            );
        }

        return $this;
    }

    public function getProduct(): Product
    {
        return Product::find($this->getProductId());
    }

    public function getRecipient(): Recipient
    {
        return Recipient::find($this->getRecipientId());
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

    public function getPrice(): float
    {
        return $this->getDataFloat(self::PRICE);
    }

    public function setPrice(float $value): self
    {
        return $this->setDataFloat(self::PRICE, $value);
    }

    public function getPricePayout(): float
    {
        return $this->getDataFloat(self::PRICE_PAYOUT);
    }

    public function setPricePayout(float $value): self
    {
        return $this->setDataFloat(self::PRICE_PAYOUT, $value);
    }

    public function getProductId(): int
    {
        return $this->getDataInt(self::PRODUCT_ID);
    }

    public function setProductId(int $value): self
    {
        return $this->setDataInt(self::PRODUCT_ID, $value);
    }

    public function getRecipientId(): int
    {
        return $this->getDataInt(self::RECIPIENT_ID);
    }

    public function setRecipientId(int $value): self
    {
        return $this->setDataInt(self::RECIPIENT_ID, $value);
    }
}

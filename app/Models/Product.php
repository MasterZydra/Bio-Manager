<?php

namespace App\Models;

use Framework\Database\Database;
use Framework\Database\Model;

class Product extends Model
{
    public function __construct(
        private ?int $id,
        private string $name,
        private bool $isDiscontinued,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getIsDiscontinued(): bool
    {
        return $this->isDiscontinued;
    }

    public function setIsDiscontinued(bool $isDiscontinued): Product
    {
        $this->isDiscontinued = $isDiscontinued;
        return $this;
    }

    public function save(): Product
    {
        if ($this->getId() === null) {
            Database::query(
                'INSERT INTO products (`name`, isDiscontinued) ' .
                'VALUES (\'' . $this->getName() . '\', ' . ($this->getIsDiscontinued() ? 1 : 0) . ')'
            );
        } else {
            Database::query(
                'UPDATE products SET `name`=\'' . $this->getName() . '\', isDiscontinued=' . ($this->getIsDiscontinued() ? 1 : 0) . ' ' .
                'WHERE id=' . $this->getId()
            );
        }

        return $this;
    }

    public function delete(): Product
    {
        Database::query('DELETE FROM products WHERE id=' . $this->getId());
        return $this;
    }

    public static function loadById(int $id): ?Product
    {
        $dataSet = Database::query('SELECT * FROM products WHERE id = ' . $id);
        if ($dataSet === false) {
            return [];
        }

        /** @var \mysqli_result $result */
        if ($dataSet->num_rows !== 1) {
            return null;
        }

        return Product::newProduct($dataSet->fetch_assoc());
    }

    public static function all(): array
    {
        $dataSet = Database::query('SELECT * FROM products');
        if ($dataSet === false) {
            return [];
        }

        $all = [];
        while ($row = $dataSet->fetch_assoc()) {
            array_push($all, self::newProduct($row));
        }
        return $all;
    }

    private static function newProduct(array $row): Product
    {
        return new Product($row['id'], $row['name'], $row['isDiscontinued'] === '0' ? false : true);
    }
}
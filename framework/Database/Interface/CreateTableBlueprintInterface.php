<?php

namespace Framework\Database\Interface;

/** Create SQL statements for generating tables */
interface CreateTableBlueprintInterface
{
    public function id(): void;

    public function bool(string $column, bool $nullable = false, bool $default = false): void;

    public function int(string $column, bool $nullable = false, array $foreignKey = []): void;

    public function string(string $column, string $length, bool $nullable = false, bool $unique = false): void;

    public function timestamps(): void;

    public function build(): array;
}
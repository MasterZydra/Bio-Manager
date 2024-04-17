<?php

namespace Framework\Database\Interface;

/** Create SQL statements for generating tables */
interface CreateTableBlueprintInterface
{
    public function id(): self;

    public function bool(string $column, bool $nullable = false, bool $default = false): self;

    public function int(string $column, bool $nullable = false, array $foreignKey = []): self;

    public function float(string $column, bool $nullable = false): self;

    public function string(string $column, string $length, bool $nullable = false, bool $unique = false): self;

    public function date(string $column, bool $nullable = false): self;

    public function timestamps(): self;

    public function build(): array;
}
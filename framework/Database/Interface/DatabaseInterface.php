<?php

declare(strict_types = 1);

namespace Framework\Database\Interface;

interface DatabaseInterface
{
    /** Open connection to the DB */
    public function connect(): void;

    /** Close the open connection */
    public function disconnect(): void;

    /** Execute the given query */
    public function unprepared(string $query): ResultInterface|false;

    /** Execute the given prepared statement */
    public function prepared(string $query, string $colTypes, ...$values): ResultInterface|false;
}
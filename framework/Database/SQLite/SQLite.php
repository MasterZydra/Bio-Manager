<?php

namespace Framework\Database\SQLite;

use Framework\Database\Interface\DatabaseInterface;
use Framework\Database\Interface\ResultInterface;
use Framework\Facades\File;
use RuntimeException;
use SQLite3;

/** This class simplifies the connection to SQLite and executing queries. */
class SQLite implements DatabaseInterface
{
    private ?SQLite3 $sqlite = null;

    public function __construct(
        private string $filename,
    ) {
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    /** Open connection to the DB */
    public function connect(): void
    {
        $dirname = dirname($this->filename);
        if ($dirname !== '.') {
            File::mkdir($dirname);
        }
        $this->sqlite = new SQLite3($this->filename);
    }

    /** Close the open connection */
    public function disconnect(): void
    {
        if ($this->sqlite === null) {
            return;
        }

        $this->sqlite->close();
        $this->sqlite = null;
    }

    /** Execute the given query */
    public function unprepared(string $query): ResultInterface|false
    {
        if ($this->sqlite === null) {
            return false;
        }

        return new SQLiteResult($this->sqlite->query($query));
    }

    /** Execute the given prepared statement */
    public function prepared(string $query, string $colTypes, ...$values): ResultInterface|false
    {
        $stmt = $this->sqlite->prepare($query);
        if ($stmt === false) {
            return false;
        }

        if (count($values) !== strlen($colTypes)) {
            throw new RuntimeException('Given amount of column types and values does not match');
        }

        $paramIndex = 1;
        foreach ($values as $value) {
            $stmt->bindParam($paramIndex, $value, $this->charToType($colTypes[$paramIndex - 1]));
            $paramIndex += 1;
        }

        return new SQLiteResult($stmt->execute());
    }

    private function charToType(string $char): int
    {
        return match ($char) {
            'i' => SQLITE3_INTEGER,
            'd' => SQLITE3_FLOAT,
            's' => SQLITE3_TEXT,
            default => throw new RuntimeException('ColType "' . $char . '" is not supported')
        };
    }
}
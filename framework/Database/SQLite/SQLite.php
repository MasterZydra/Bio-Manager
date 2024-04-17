<?php

namespace Framework\Database\SQLite;

use Framework\Database\Interface\DatabaseInterface;
use Framework\Database\Interface\ResultInterface;
use Framework\Facades\File;
use Framework\Facades\Path;
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
        $path = Path::join(__DIR__, '..', '..', '..', $this->filename);
        $dirname = dirname($path);
        if ($dirname !== '.') {
            File::mkdir($dirname);
        }
        $this->sqlite = new SQLite3($path);
        $this->sqlite->enableExceptions(true);
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
        $this->connect();
        return new SQLiteResult($this->sqlite->query($query));
    }

    /** Execute the given prepared statement */
    public function prepared(string $query, string $colTypes, ...$values): ResultInterface|false
    {
        $this->connect();
        $stmt = $this->sqlite->prepare($query);
        if ($stmt === false) {
            return false;
        }

        if (count($values) !== strlen($colTypes)) {
            throw new RuntimeException('Given amount of column types and values does not match');
        }

        $paramIndex = 1;
        foreach ($values as $value) {
            $stmt->bindValue($paramIndex, $value);
            $paramIndex += 1;
        }

        return new SQLiteResult($stmt->execute());
    }
}
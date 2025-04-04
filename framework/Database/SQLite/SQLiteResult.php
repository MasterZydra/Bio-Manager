<?php

declare(strict_types = 1);

namespace Framework\Database\SQLite;

use Framework\Database\Interface\ResultInterface;
use SQLite3Result;

class SQLiteResult implements ResultInterface
{
    public function __construct(
        private SQLite3Result|false $result,
    ) {
    }

    public function fetch(): array|false
    {
        if ($this->result === false) {
            return false;
        }

        return $this->result->fetchArray(SQLITE3_ASSOC);
    }

    public function numRows(): int
    {
        if ($this->result === false) {
            return 0;
        }

        $rows = 0;
        $this->result->reset();
        while ($this->fetch() !== false) {
            $rows += 1;
        }
        $this->result->reset();
        return $rows;
    }
}
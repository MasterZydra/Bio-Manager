<?php

declare(strict_types = 1);

namespace Framework\Database\MariaDB;

class MariaDbResult implements \Framework\Database\Interface\ResultInterface
{
    public function __construct(
        private \mysqli_result|bool $result,
    ) {
    }

    public function fetch(): array|false
    {
        if ($this->result === false || $this->result === true) {
            return false;
        }

        $row = $this->result->fetch_assoc();
        if ($row === null) {
            return false;
        }
        return $row;
    }

    public function numRows(): int
    {
        if ($this->result === false) {
            return 0;
        }

        return $this->result->num_rows;
    }
}
<?php

namespace Framework\Database;

use mysqli_result;

class MariaDbResult implements ResultInterface
{
    public function __construct(
        private mysqli_result|false $result,
    ) {
    }

    public function fetch(): array|false
    {
        if ($this->result === false) {
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
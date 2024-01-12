<?php

namespace Framework\Database;

use mysqli;
use mysqli_result;

/** This class simplifies the connection to MariaDB and executing queries. */
class MariaDB
{
    private ?mysqli $mysqli;

    public function __construct(
        private string $host,
        private int $port,
        private string $database,
        private string $username,
        private string $password,
    ) {
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    /** Open connection to the DB */
    public function connect(): void
    {
        $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
        mysqli_select_db($this->mysqli, $this->database);
    }

    /** Close the open connection */
    public function disconnect(): void
    {
        if ($this->mysqli === null) {
            return;
        }

        mysqli_close($this->mysqli);
        $this->mysqli = null;
    }

    /** Execute the given query */
    public function unprepared(string $query): mysqli_result|bool
    {
        if ($this->mysqli === null) {
            return false;
        }

        return $this->mysqli->query($query);
    }

    /** Execute the given prepared statement */
    public function prepared(string $query, string $colTypes, ...$values): mysqli_result|bool
    {
        $stmt = $this->mysqli->prepare($query);
        if ($stmt === false) {
            return false;
        }

        $stmt->bind_param($colTypes, ...$values);
        if (!$stmt->execute()) {
            return false;
        }

        return $stmt->get_result();
    }
}
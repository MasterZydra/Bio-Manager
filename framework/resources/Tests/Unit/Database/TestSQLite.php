<?php

use Framework\Database\Database;
use Framework\Database\SQLite\CreateTableBlueprint;
use Framework\Database\SQLite\SQLite;
use Framework\Test\TestCase;

class TestSQLite extends TestCase
{
    private string $dbName = 'resources/Tests/tmp/db/testDb';

    private function cleanup(): void
    {
        if (file_exists($this->dbName)) {
            unlink($this->dbName);
        }
    }

    public function testFileCreation(): void
    {
        $this->cleanup();

        $db = new SQLite($this->dbName);
        $db->connect();

        $this->assertTrue(file_exists($this->dbName));
    }

    public function testTableCreation(): void {
        $this->cleanup();

        $db = new SQLite($this->dbName);
        $db->connect();

        // Create a table 'users
        $blueprint = (new CreateTableBlueprint('users'))
            ->id()
            ->string('firstname', 30)
            ->int('age', true)
            ->bool('isLocked', default: true)
            ->timestamps();

        foreach ($blueprint->build() as $sql) {
            $db->unprepared($sql);
        }

        // Insert some data
        $db->unprepared('INSERT INTO users (firstname, age) VALUES (\'Max\', 42);');
        $db->unprepared('INSERT INTO users (firstname, age) VALUES (\'Maria\', 36);');

        // Wait a second. The 'updatedAt' column will change.
        sleep(1);
        $db->unprepared('UPDATE users SET isLocked = 0 WHERE id = 1;');

        // Select all users
        $result = $db->unprepared('SELECT * FROM users;');
        $this->assertTrue($result !== false);

        $user1 = $result->fetch();
        $this->assertEquals(1, $user1['id']);
        $this->assertEquals(42, $user1['age']);
        $this->assertTrue($user1['createdAt'] !== $user1['updatedAt']);

        $user2 = $result->fetch();
        $this->assertEquals(2, $user2['id']);
        $this->assertEquals(36, $user2['age']);
        $this->assertEquals($user2['createdAt'], $user2['updatedAt']);
    }
}
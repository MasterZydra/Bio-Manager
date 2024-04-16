<?php

use Framework\Database\Database;
use Framework\Database\SQLite\CreateTableBlueprint;
use Framework\Database\SQLite\SQLite;
use Framework\Test\TestCase;

class TestSQLite extends TestCase
{
    private string $dbName = 'tests/tmp/db/testDb';

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

    public function testTableCreate(): void {
        $this->cleanup();

        $db = new SQLite($this->dbName);
        $db->connect();

        // $blueprint = new CreateTableBlueprint('user');
        // $blueprint->id();
        // $blueprint->string('firstname', 30);
        // $blueprint->int('age', true);
        // $blueprint->bool('isLocked', default: true);
        // $blueprint->timestamps();

        // Database::executeBlueprint($blueprint);

        // $db->unprepared('INSERT INTO user (firstname, age) VALUES (\'Max\', 42);');
        // sleep(2);
        // $db->unprepared('UPDATE user SET isLocked = 0 WHERE id = 1;');
        // $db->unprepared('INSERT INTO user (firstname, age) VALUES (\'Maria\', 36);');
        // /** @var \SQLite3Result $result */
        // $result = $db->unprepared('SELECT * FROM user;');

        // $data = [];
        // while ($res = $result->fetchArray(SQLITE3_ASSOC)) {
        //     $data[] = $res;
        // }
        // $this->assertEquals([], $data);
        // $this->assertEquals("", "");
    //     $db->unprepared("SELECT 
    //     name
    // FROM 
    //     sqlite_schema
    // WHERE 
    //     type ='table' AND 
    //     name NOT LIKE 'sqlite_%';");
    }
}
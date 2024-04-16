<?php

use Framework\Database\SQLite\CreateTableBlueprint;
use Framework\Test\TestCase;

class TestSQLiteCreateTableBlueprint extends TestCase
{
    public function testId(): void
    {
        $blueprint = new CreateTableBlueprint('user');
        $blueprint->id();
        $this->assertEquals(['CREATE TABLE `user` (id INTEGER PRIMARY KEY);'], $blueprint->build());
    }

    public function testBool(): void
    {
        $blueprint = new CreateTableBlueprint('user');
        $blueprint->bool('isLocked');
        $this->assertEquals(['CREATE TABLE `user` (isLocked TINYINT(1) NOT NULL DEFAULT 0);'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->bool('isLocked', nullable: true);
        $this->assertEquals(['CREATE TABLE `user` (isLocked TINYINT(1) NULL DEFAULT 0);'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->bool('isLocked', default: true);
        $this->assertEquals(['CREATE TABLE `user` (isLocked TINYINT(1) NOT NULL DEFAULT 1);'], $blueprint->build());
    }

    public function testInt(): void
    {
        $blueprint = new CreateTableBlueprint('user');
        $blueprint->int('age');
        $this->assertEquals(['CREATE TABLE `user` (age INTEGER NOT NULL);'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->int('age', true);
        $this->assertEquals(['CREATE TABLE `user` (age INTEGER NULL);'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->int('roleId', foreignKey: ['roles' => 'id']);
        $this->assertEquals(['CREATE TABLE `user` (roleId INTEGER NOT NULL,FOREIGN KEY (roleId) REFERENCES `roles` (`id`));'], $blueprint->build());
    }

    public function testString(): void
    {
        $blueprint = new CreateTableBlueprint('user');
        $blueprint->string('firstname', 30);
        $this->assertEquals(['CREATE TABLE `user` (firstname VARCHAR(30) NOT NULL);'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->string('firstname', 30, true);
        $this->assertEquals(['CREATE TABLE `user` (firstname VARCHAR(30) NULL);'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->string('firstname', 30, unique: true);
        $this->assertEquals(['CREATE TABLE `user` (firstname VARCHAR(30) NOT NULL,UNIQUE(firstname));'], $blueprint->build());
    }

    public function testTimestamps(): void
    {
        $blueprint = new CreateTableBlueprint('user');
        $blueprint->timestamps();
        $this->assertEquals(
            [
                'CREATE TABLE `user` (createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP);',
                'CREATE TRIGGER user_updateAt AFTER UPDATE ON `user` BEGIN UPDATE user SET updatedAt=CURRENT_TIMESTAMP WHERE id = NEW.id; END;'
            ],
            $blueprint->build()
        );
    }

    public function testCombined(): void
    {
        $blueprint = new CreateTableBlueprint('user');
        $blueprint->id();
        $blueprint->string('firstname', 30);
        $blueprint->int('age', true);
        $blueprint->bool('isLocked', default: true);
        $blueprint->timestamps();
        $this->assertEquals(
            [
                'CREATE TABLE `user` (id INTEGER PRIMARY KEY,firstname VARCHAR(30) NOT NULL,age INTEGER NULL,isLocked TINYINT(1) NOT NULL DEFAULT 1,createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP);',
                'CREATE TRIGGER user_updateAt AFTER UPDATE ON `user` BEGIN UPDATE user SET updatedAt=CURRENT_TIMESTAMP WHERE id = NEW.id; END;'
            ],
                $blueprint->build()
            );
    }

}
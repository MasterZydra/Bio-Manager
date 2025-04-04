<?php

use Framework\Database\SQLite\CreateTableBlueprint;

return new class extends \Framework\Test\TestCase
{
    public function testId(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->id();
        $this->assertEquals(['CREATE TABLE `user` (id INTEGER PRIMARY KEY);'], $blueprint->build());
    }

    public function testBool(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->bool('isLocked');
        $this->assertEquals(['CREATE TABLE `user` (`isLocked` TINYINT(1) NOT NULL DEFAULT 0);'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->bool('isLocked', nullable: true);
        $this->assertEquals(['CREATE TABLE `user` (`isLocked` TINYINT(1) NULL DEFAULT 0);'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->bool('isLocked', default: true);
        $this->assertEquals(['CREATE TABLE `user` (`isLocked` TINYINT(1) NOT NULL DEFAULT 1);'], $blueprint->build());
    }

    public function testInt(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->int('age');
        $this->assertEquals(['CREATE TABLE `user` (`age` INTEGER NOT NULL);'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->int('age', true);
        $this->assertEquals(['CREATE TABLE `user` (`age` INTEGER NULL);'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->int('roleId', foreignKey: ['roles' => 'id']);
        $this->assertEquals(['CREATE TABLE `user` (`roleId` INTEGER NOT NULL,FOREIGN KEY (roleId) REFERENCES `roles` (`id`));'], $blueprint->build());
    }

    public function testFloat(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->float('height');
        $this->assertEquals(['CREATE TABLE `user` (`height` REAL NOT NULL);'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->float('height', true);
        $this->assertEquals(['CREATE TABLE `user` (`height` REAL NULL);'], $blueprint->build());
    }

    public function testString(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->string('firstname', 30);
        $this->assertEquals(['CREATE TABLE `user` (`firstname` VARCHAR(30) NOT NULL);'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->string('firstname', 30, true);
        $this->assertEquals(['CREATE TABLE `user` (`firstname` VARCHAR(30) NULL);'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->string('firstname', 30, unique: true);
        $this->assertEquals(['CREATE TABLE `user` (`firstname` VARCHAR(30) NOT NULL UNIQUE);'], $blueprint->build());
    }

    public function testDate(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->date('birthdate');
        $this->assertEquals(['CREATE TABLE `user` (`birthdate` DATE NOT NULL);'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->date('birthdate', true);
        $this->assertEquals(['CREATE TABLE `user` (`birthdate` DATE NULL);'], $blueprint->build());
    }

    public function testTimestamps(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->timestamps();
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
        $blueprint = (new CreateTableBlueprint('user'))
            ->id()
            ->string('firstname', 30)
            ->int('age', true)
            ->float('height')
            ->bool('isLocked', default: true)
            ->timestamps();
        $this->assertEquals(
            [
                'CREATE TABLE `user` (id INTEGER PRIMARY KEY,`firstname` VARCHAR(30) NOT NULL,`age` INTEGER NULL,`height` REAL NOT NULL,`isLocked` TINYINT(1) NOT NULL DEFAULT 1,createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP);',
                'CREATE TRIGGER user_updateAt AFTER UPDATE ON `user` BEGIN UPDATE user SET updatedAt=CURRENT_TIMESTAMP WHERE id = NEW.id; END;'
            ],
            $blueprint->build()
        );
    }
};

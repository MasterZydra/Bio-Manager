<?php

use Framework\Config\Config;
use Framework\Database\CreateTableBlueprint;
use Framework\Test\TestCase;

class TestCreateTableBlueprint extends TestCase
{
    public function testId(): void
    {
        Config::useTestMode();

        // MySQL

        Config::setTestValues('DB_CONNECTION', 'mysql');

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->id();
        $this->assertEquals(['CREATE TABLE `user` (id INT auto_increment,PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        // SQLite

        Config::setTestValues('DB_CONNECTION', 'sqlite');

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->id();
        $this->assertEquals(['CREATE TABLE `user` (id INTEGER PRIMARY KEY);'], $blueprint->build());
    }

    public function testBool(): void
    {
        Config::useTestMode();

        // MySQL

        Config::setTestValues('DB_CONNECTION', 'mysql');

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->bool('isLocked');
        $this->assertEquals(['CREATE TABLE `user` (isLocked TINYINT(1) NOT NULL DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->bool('isLocked', nullable: true);
        $this->assertEquals(['CREATE TABLE `user` (isLocked TINYINT(1) NULL DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->bool('isLocked', default: true);
        $this->assertEquals(['CREATE TABLE `user` (isLocked TINYINT(1) NOT NULL DEFAULT 1) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        // SQLite

        Config::setTestValues('DB_CONNECTION', 'sqlite');

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
        Config::useTestMode();

        // MySQL

        Config::setTestValues('DB_CONNECTION', 'mysql');

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->int('age');
        $this->assertEquals(['CREATE TABLE `user` (age INT NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->int('age', true);
        $this->assertEquals(['CREATE TABLE `user` (age INT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        // SQLite

        Config::setTestValues('DB_CONNECTION', 'sqlite');

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->int('age');
        $this->assertEquals(['CREATE TABLE `user` (age INTEGER NOT NULL);'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->int('age', true);
        $this->assertEquals(['CREATE TABLE `user` (age INTEGER NULL);'], $blueprint->build());
    }

    public function testString(): void
    {
        Config::useTestMode();

        // MySQL

        Config::setTestValues('DB_CONNECTION', 'mysql');

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->string('firstname', 30);
        $this->assertEquals(['CREATE TABLE `user` (firstname VARCHAR(30) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->string('firstname', 30, true);
        $this->assertEquals(['CREATE TABLE `user` (firstname VARCHAR(30) NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        // SQLite

        Config::setTestValues('DB_CONNECTION', 'sqlite');

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->string('firstname', 30);
        $this->assertEquals(['CREATE TABLE `user` (firstname VARCHAR(30) NOT NULL);'], $blueprint->build());

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->string('firstname', 30, true);
        $this->assertEquals(['CREATE TABLE `user` (firstname VARCHAR(30) NULL);'], $blueprint->build());
    }

    public function testTimestamps(): void
    {
        Config::useTestMode();

        // MySQL

        Config::setTestValues('DB_CONNECTION', 'mysql');

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->timestamps();
        $this->assertEquals(['CREATE TABLE `user` (createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        // SQLite

        Config::setTestValues('DB_CONNECTION', 'sqlite');

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
        Config::useTestMode();

        // MySQL

        Config::setTestValues('DB_CONNECTION', 'mysql');

        $blueprint = new CreateTableBlueprint('user');
        $blueprint->id();
        $blueprint->string('firstname', 30);
        $blueprint->int('age', true);
        $blueprint->bool('isLocked', default: true);
        $blueprint->timestamps();
        $this->assertEquals(['CREATE TABLE `user` (id INT auto_increment,PRIMARY KEY (id),firstname VARCHAR(30) NOT NULL,age INT NULL,isLocked TINYINT(1) NOT NULL DEFAULT 1,createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        // SQLite

        Config::setTestValues('DB_CONNECTION', 'sqlite');

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
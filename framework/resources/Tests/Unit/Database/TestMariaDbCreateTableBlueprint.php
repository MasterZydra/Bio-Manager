<?php

declare(strict_types = 1);

use Framework\Database\MariaDB\CreateTableBlueprint;

return new class extends \Framework\Test\TestCase
{
    public function testId(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->id();
        $this->assertEquals(['CREATE TABLE `user` (id INT auto_increment,PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());
    }

    public function testBool(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->bool('isLocked');
        $this->assertEquals(['CREATE TABLE `user` (`isLocked` TINYINT(1) NOT NULL DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->bool('isLocked', nullable: true);
        $this->assertEquals(['CREATE TABLE `user` (`isLocked` TINYINT(1) NULL DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'));
        $blueprint->bool('isLocked', default: true);
        $this->assertEquals(['CREATE TABLE `user` (`isLocked` TINYINT(1) NOT NULL DEFAULT 1) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());
    }

    public function testInt(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->int('age');
        $this->assertEquals(['CREATE TABLE `user` (`age` INT NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->int('age', true);
        $this->assertEquals(['CREATE TABLE `user` (`age` INT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->int('roleId', foreignKey: ['roles' => 'id']);
        $this->assertEquals(['CREATE TABLE `user` (`roleId` INT NOT NULL,CONSTRAINT `fkUserRoleId` FOREIGN KEY (roleId) REFERENCES `roles` (`id`) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());
    }

    public function testFloat(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->float('height');
        $this->assertEquals(['CREATE TABLE `user` (`height` FLOAT NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->float('height', true);
        $this->assertEquals(['CREATE TABLE `user` (`height` FLOAT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());
    }

    public function testString(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->string('firstname', 30);
        $this->assertEquals(['CREATE TABLE `user` (`firstname` VARCHAR(30) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->string('firstname', 30, true);
        $this->assertEquals(['CREATE TABLE `user` (`firstname` VARCHAR(30) NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->string('firstname', 30, unique: true);
        $this->assertEquals(['CREATE TABLE `user` (`firstname` VARCHAR(30) NOT NULL,UNIQUE KEY `ukUserFirstname` (firstname)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());
    }

    public function testDate(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->date('birthdate');
        $this->assertEquals(['CREATE TABLE `user` (`birthdate` DATE NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());

        $blueprint = (new CreateTableBlueprint('user'))->date('birthdate', true);
        $this->assertEquals(['CREATE TABLE `user` (`birthdate` DATE NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());
    }

    public function testTimestamps(): void
    {
        $blueprint = (new CreateTableBlueprint('user'))->timestamps();
        $this->assertEquals(['CREATE TABLE `user` (createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());
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
        $this->assertEquals(['CREATE TABLE `user` (id INT auto_increment,PRIMARY KEY (id),`firstname` VARCHAR(30) NOT NULL,`age` INT NULL,`height` FLOAT NOT NULL,`isLocked` TINYINT(1) NOT NULL DEFAULT 1,createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'], $blueprint->build());
    }
};

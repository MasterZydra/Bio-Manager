<?php

use Framework\Database\Query\ColType;
use Framework\Database\Query\Condition;
use Framework\Database\Query\SortOrder;
use Framework\Database\Query\WhereCombine;
use Framework\Database\QueryBuilder;
use Framework\Test\TestCase;

class TestQueryBuilder extends TestCase
{
    public function testSelect(): void
    {
        $queryBuilder = QueryBuilder::new('users');
        $this->assertEquals('SELECT * FROM `users`', $queryBuilder->build());
        $this->assertTrue($queryBuilder->isWhereEmpty());
        $this->assertEquals('', $queryBuilder->getColTypes());
        $this->assertEquals([], $queryBuilder->getValues());

        $queryBuilder = QueryBuilder::new('users')->select('id');
        $this->assertEquals('SELECT id FROM `users`', $queryBuilder->build());
        $this->assertTrue($queryBuilder->isWhereEmpty());
        $this->assertEquals('', $queryBuilder->getColTypes());
        $this->assertEquals([], $queryBuilder->getValues());

        $queryBuilder = QueryBuilder::new('users')->select('id')->select('username');
        $this->assertEquals('SELECT id, username FROM `users`', $queryBuilder->build());
        $this->assertTrue($queryBuilder->isWhereEmpty());
        $this->assertEquals('', $queryBuilder->getColTypes());
        $this->assertEquals([], $queryBuilder->getValues());
    }

    public function testWhere(): void
    {
        $queryBuilder = QueryBuilder::new('users')->where(ColType::Int, 'id', Condition::Equal, 42);
        $this->assertEquals('SELECT * FROM `users` WHERE `id` = ?', $queryBuilder->build());
        $this->assertFalse($queryBuilder->isWhereEmpty());
        $this->assertEquals('i', $queryBuilder->getColTypes());
        $this->assertEquals([42], $queryBuilder->getValues());

        $queryBuilder = QueryBuilder::new('users')
            ->where(ColType::Int, 'id', Condition::Equal, 42)
            ->where(ColType::Str, 'username', Condition::Like, '%abc%');
        $this->assertEquals('SELECT * FROM `users` WHERE `id` = ? AND `username` LIKE ?', $queryBuilder->build());
        $this->assertFalse($queryBuilder->isWhereEmpty());
        $this->assertEquals('is', $queryBuilder->getColTypes());
        $this->assertEquals([42, '%abc%'], $queryBuilder->getValues());

        $queryBuilder = QueryBuilder::new('users')
            ->where(ColType::Int, 'id', Condition::Equal, 42)
            ->where(ColType::Null, 'username', Condition::Is, 'NULL', WhereCombine::Or);
        $this->assertEquals('SELECT * FROM `users` WHERE `id` = ? OR `username` IS NULL', $queryBuilder->build());
        $this->assertFalse($queryBuilder->isWhereEmpty());
        $this->assertEquals('i', $queryBuilder->getColTypes());
        $this->assertEquals([42], $queryBuilder->getValues());
    }

    public function testOrderBy(): void
    {
        $queryBuilder = QueryBuilder::new('users')->orderBy('username', SortOrder::Desc);
        $this->assertEquals('SELECT * FROM `users` ORDER BY `username` DESC', $queryBuilder->build());
        $this->assertTrue($queryBuilder->isWhereEmpty());
        $this->assertEquals('', $queryBuilder->getColTypes());
        $this->assertEquals([], $queryBuilder->getValues());

        $queryBuilder = QueryBuilder::new('users')
            ->orderBy('username', SortOrder::Desc)
            ->orderBy('createdAt', SortOrder::Asc);
        $this->assertEquals('SELECT * FROM `users` ORDER BY `username` DESC, `createdAt` ASC', $queryBuilder->build());
        $this->assertTrue($queryBuilder->isWhereEmpty());
        $this->assertEquals('', $queryBuilder->getColTypes());
        $this->assertEquals([], $queryBuilder->getValues());
    }
}

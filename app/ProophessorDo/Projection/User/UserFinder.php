<?php
/**
 * This file is part of prooph/proophessor-do.
 * (c) 2014-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2015-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Prooph\ProophessorDo\Projection\User;

use Doctrine\DBAL\Connection;
use Prooph\ProophessorDo\Projection\Table;

class UserFinder
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->setFetchMode(\PDO::FETCH_OBJ);
    }

    public function findAll(): array
    {
        return $this->connection->fetchAll(sprintf('SELECT * FROM %s', Table::USER));
    }

    /**
     * @param string $userId
     * @return null|\stdClass
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById(string $userId): ?\stdClass
    {
        $stmt = $this->connection->prepare(sprintf('SELECT * FROM %s WHERE id = :user_id', Table::USER));
        $stmt->bindValue('user_id', $userId);
        $stmt->execute();

        $result = $stmt->fetch();

        if (false === $result) {
            return null;
        }

        return $result;
    }

    /**
     * @param string $emailAddress
     * @return null|\stdClass
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findOneByEmailAddress(string $emailAddress): ?\stdClass
    {
        $stmt = $this->connection->prepare(sprintf('SELECT * FROM %s WHERE email = :email LIMIT 1', Table::USER));
        $stmt->bindValue('email', $emailAddress);
        $stmt->execute();

        $result = $stmt->fetch();

        if (false === $result) {
            return null;
        }

        return $result;
    }

    /**
     * @param string $todoId
     * @return null|\stdClass
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findUserOfTodo(string $todoId): ?\stdClass
    {
        $stmt = $this->connection->prepare(sprintf(
            'SELECT u.* FROM %s as u JOIN %s as t ON u.id = t.assignee_id WHERE t.id = :todo_id',
            Table::USER,
            Table::TODO
        ));
        $stmt->bindValue('todo_id', $todoId);
        $stmt->execute();

        $result = $stmt->fetch();

        if (false === $result) {
            return null;
        }

        return $result;
    }
}

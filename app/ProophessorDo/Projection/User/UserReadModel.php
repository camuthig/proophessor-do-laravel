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
use Doctrine\DBAL\Platforms\PostgreSqlPlatform;
use Prooph\EventStore\Projection\AbstractReadModel;
use Prooph\ProophessorDo\Projection\Table;

final class UserReadModel extends AbstractReadModel
{
    /**
     * @var Connection
     */
    private $connection;

    /** @var \Doctrine\DBAL\Platforms\AbstractPlatform */
    private $platform;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->platform = $this->connection->getDatabasePlatform();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function init(): void
    {
        $tableName = Table::USER;

        $schema = new \Doctrine\DBAL\Schema\Schema();

        $table = $schema->createTable($tableName);
        $table->addColumn('id', 'string', ['unsigned' => true, 'length' => 36, 'notnull' => true]);
        $table->addColumn('name', 'string', ['length' => 50, 'notnull' => true]);
        $table->addColumn('email', 'string', ['length' => 100, 'notnull' => true]);
        $table->addColumn('open_todos', 'integer', ['length' => 11, 'notnull' => true, 'default' => 0]);
        $table->addColumn('done_todos', 'integer', ['length' => 11, 'notnull' => true, 'default' => 0]);
        $table->addColumn('expired_todos', 'integer', ['length' => 32, 'notnull' => true, 'default' => 0]);
        $table->setPrimaryKey(['id']);

        foreach ($schema->toSql($this->platform) as $query) {
            $statement = $this->connection->prepare($query);
            $statement->execute();
        }
    }

    public function isInitialized(): bool
    {
        return $this->connection->getSchemaManager()->tablesExist([Table::USER]);
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function reset(): void
    {
        $this->connection->executeUpdate($this->platform->getTruncateTableSQL(Table::USER, true));
    }

    public function delete(): void
    {
        $this->connection->getSchemaManager()->dropTable(Table::USER);
    }

    protected function insert(array $data): void
    {
        $this->connection->insert(Table::USER, $data);
    }

    protected function postTodo(string $assigneeId): void
    {
        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos + 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $assigneeId);

        $stmt->execute();
    }

    protected function markTodoAsDone(string $assigneeId): void
    {
        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos - 1, done_todos = done_todos + 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $assigneeId);

        $stmt->execute();
    }

    protected function reopenTodo(string $assigneeId): void
    {
        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos + 1, done_todos = done_todos - 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $assigneeId);

        $stmt->execute();
    }

    protected function markTodoAsExpired(string $assigneeId): void
    {
        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos - 1, expired_todos = expired_todos + 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $assigneeId);

        $stmt->execute();
    }

    protected function unmarkedTodoAsExpired(string $assigneeId): void
    {
        $stmt = $this->connection->prepare(sprintf('UPDATE %s SET open_todos = open_todos + 1, expired_todos = expired_todos - 1 WHERE id = :assignee_id', Table::USER));

        $stmt->bindValue('assignee_id', $assigneeId);

        $stmt->execute();
    }
}

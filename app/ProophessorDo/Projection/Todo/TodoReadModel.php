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

namespace Prooph\ProophessorDo\Projection\Todo;

use Doctrine\DBAL\Connection;
use Prooph\EventStore\Projection\AbstractReadModel;
use Prooph\ProophessorDo\Projection\Table;

final class TodoReadModel extends AbstractReadModel
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
        $tableName = Table::TODO;

        $schema = new \Doctrine\DBAL\Schema\Schema();

        $table = $schema->createTable($tableName);
        $table->addColumn('id', 'string', ['unsigned' => true, 'length' => 36, 'notnull' => true]);
        $table->addColumn('assignee_id', 'string', ['unsigned' => true, 'length' => 36, 'notnull' => true]);
        $table->addColumn('text', 'text', ['notnull' => true]);
        $table->addColumn('status', 'string', ['length' => 7, 'notnull' => true]);
        $table->addColumn('deadline', 'string', ['length' => 30, 'default' => null]);
        $table->addColumn('reminder', 'string', ['length' => 30, 'default' => null]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['assignee_id', 'status'], 'idx_a_status');
        $table->addIndex(['status'], 'idx_status');

        foreach ($schema->toSql($this->platform) as $query) {
            $statement = $this->connection->prepare($query);
            $statement->execute();
        }
    }

    public function isInitialized(): bool
    {
        return $this->connection->getSchemaManager()->tablesExist([Table::TODO]);
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function reset(): void
    {
        $this->connection->executeUpdate($this->platform->getTruncateTableSQL(Table::TODO, true));
    }

    public function delete(): void
    {
        $this->connection->getSchemaManager()->dropTable(Table::TODO);
    }

    protected function insert(array $data): void
    {
        $this->connection->insert(Table::TODO, $data);
    }

    protected function update(array $data, array $identifier): void
    {
        $this->connection->update(
            Table::TODO,
            $data,
            $identifier
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Providers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Illuminate\Support\ServiceProvider;
use Prooph\ProophessorDo\Infrastructure\Service\ChecksUniqueUsersEmailAddressFromReadModel;
use Prooph\ProophessorDo\Model\User\Service\ChecksUniqueUsersEmailAddress;

class ProophessorDoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ChecksUniqueUsersEmailAddress::class, ChecksUniqueUsersEmailAddressFromReadModel::class);

        $this->app->singleton(Connection::class, function () {
            $default = config('database.default');

            switch ($default) {
                case 'mysql':
                    $driver = 'pdo_mysql';
                    break;
                case 'pgsql':
                    $driver = 'pdo_pgsql';
            }

            return DriverManager::getConnection([
                'dbname'   => config(sprintf('database.connections.%s.database', $default)),
                'user'     => config(sprintf('database.connections.%s.username', $default)),
                'password' => config(sprintf('database.connections.%s.password', $default)),
                'host'     => config(sprintf('database.connections.%s.host', $default)),
                'port'     => config(sprintf('database.connections.%s.port', $default)),
                'driver'   => $driver,
            ]);
        });
    }
}

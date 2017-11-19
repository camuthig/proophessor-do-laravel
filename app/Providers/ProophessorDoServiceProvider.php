<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prooph\ProophessorDo\Infrastructure\Service\ChecksUniqueUsersEmailAddressFromReadModel;
use Prooph\ProophessorDo\Model\User\Service\ChecksUniqueUsersEmailAddress;

class ProophessorDoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ChecksUniqueUsersEmailAddress::class, ChecksUniqueUsersEmailAddressFromReadModel::class);
    }
}

# ProophessorDo Laravel

**Archived: This project is archived and not receiving updates.**

A port of the ProophessorDo sample application built by the prooph organization
using the Laravel framework.

The majority of the code in this application is taken directly from either the
original [ProophessorDo application](https://github.com/prooph/proophessor-do) or the [Symfony application](https://github.com/prooph/proophessor-do-symfony)
and is reused here to ensure parity. Most notably, all of the `App\ProoophessorDo`
namespace as well as the view are taken from the original projects.

## Requirements

* PHP 7.1+
* MySQL 5.7+

## Setup

```bash
composer install

# Update the .env to point to your database

php artisan migrate
php artisan event-store:event-store:create-stream mysql
```

## Run the Projections

Run each of the below commands in a terminal. In a production-like environment,
you would want to run each using a tool like supervisor to keep the process
alive.

```bash
php artisan event-store:projection:run user_projection
php artisan event-store:projection:run todo_projection
php artisan event-store:projection:run todo_reminder_projection
```

## Run the Application

```bash
php artisan serve
```

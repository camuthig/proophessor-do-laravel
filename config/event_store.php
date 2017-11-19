<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Plugins
    |
    | List of all global event store plugin service IDs
    |
    |--------------------------------------------------------------------------
    */
    'plugins' => [],

    /*
    |--------------------------------------------------------------------------
    | Metadata Enrichers
    |
    | List of all global event store metadata enrichers
    |
    |--------------------------------------------------------------------------
    */
    'metadata_enrichers' => [],

    /*
    |--------------------------------------------------------------------------
    | Event Stores
    |--------------------------------------------------------------------------
    |
    | Each event store will be configured here. Currently only the mysql,
    | maria_db and postgres stores are supported. Each store will be bound to
    | event_store.stores.<key> as well as to the EventStore FQCN. Available
    | settings are:
    |
    | - persistence_strategy: The class name or service ID of the persistence strategy
    | - load_batch_size: The number of events a query should return in a single batch. Default is 1000
    | - event_streams_table: The event stream table to use. Default is event_streams
    | - message_factory: The message factory to use. Default is FCQNMessageFactory
    | - disable_transaction_handling: Boolean to turn off transaction handling. Default is false
    | - action_event_emitter: Defaults to ProophEventActionEmitter
    | - wrap_action_event_emitter: Defaults to true
    | - metadata_enrichers: A list of metadata enrichers to add to the store.
    | - plugins: A list of plugins to add to the store.
    |
    */
    'stores' => [
        'default' => 'mysql',
        'mysql' => [
            'persistence_strategy' => \Prooph\EventStore\Pdo\PersistenceStrategy\MySqlAggregateStreamStrategy::class,
        ],
        'maria_db' => [
            'persistence_strategy' => \Prooph\EventStore\Pdo\PersistenceStrategy\MariaDbAggregateStreamStrategy::class,
        ],
        'postgres' => [
            'persistence_strategy' => \Prooph\EventStore\Pdo\PersistenceStrategy\PostgresAggregateStreamStrategy::class,
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Repositories
    |--------------------------------------------------------------------------
    |
    | Each aggregate repository is configured in this structure. Each key
    | represents a different aggregate repository. Each repository is configured
    | with:
    | - store: The key of the store to use. Valid values are any key in the `stores` array above.
    | - repository_interface: An optional interface to alias the repository with.
    | - repository_class: The FQCN or service ID for the repository class.
    | - aggregate_type: The FQCN for the aggregate this store maintains.
    | - aggregate_translator: The translator for the aggregate. Defaults to \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator.
    | - stream_name: The stream name.
    | - one_stream_per_aggregate: Set this to true for an aggregate stream strategy. Default is false
    |
    */
    'repositories' => [
        'todo_list'       => [
            'store'                => 'default',
            'repository_interface' => \Prooph\ProophessorDo\Model\Todo\TodoList::class,
            'repository_class'     => \Prooph\ProophessorDo\Infrastructure\Repository\EventStoreTodoList::class,
            'aggregate_type'       => \Prooph\ProophessorDo\Model\Todo\Todo::class,
            'plugins' => [
                'event_store_bus_bridge.todo_event_publisher',
            ]
        ],
        'user_collection' => [
            'store'                => 'default',
            'repository_interface' => \Prooph\ProophessorDo\Model\User\UserCollection::class,
            'repository_class'     => \Prooph\ProophessorDo\Infrastructure\Repository\EventStoreUserCollection::class,
            'aggregate_type'       => \Prooph\ProophessorDo\Model\User\User::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Projections
    |--------------------------------------------------------------------------
    |
    | The necessary definitions for creating projections
    | - store: The name of the store. One of mysql, maria_db or postgres
    | - event_streams_table: Defaults to event_streams
    | - projections_table: Defaults to projections
    | - projections
    |   - connection: The name of the connection to use. Defaults to the same connection as the store.
    |   - read_model: The FQCN of the projection read model.
    |   - projection: The FQCN of the projection.
    |
    */
    'projection_managers' => [
        'todo_projection_manager' => [
            'store' => 'mysql',
            'projections' => [
                'user_projection' => [
                    'read_model' => \Prooph\ProophessorDo\Projection\User\UserReadModel::class,
                    'projection' => \Prooph\ProophessorDo\Projection\User\UserProjection::class,
                ],
                'todo_projection' => [
                    'read_model' => \Prooph\ProophessorDo\Projection\Todo\TodoReadModel::class,
                    'projection' => \Prooph\ProophessorDo\Projection\Todo\TodoProjection::class,
                ],
                'todo_reminder_projection' => [
                    'read_model' => \Prooph\ProophessorDo\Projection\Todo\TodoReminderReadModel::class,
                    'projection' => \Prooph\ProophessorDo\Projection\Todo\TodoReminderProjection::class,
                ]
            ]
        ],
        'maria_db' => [
            'store' => 'maria_db',
            'projections' => [
            ]
        ],
        'postgres' => [
            'store' => 'postgres',
            'projections' => [
            ]
        ]
    ]
];


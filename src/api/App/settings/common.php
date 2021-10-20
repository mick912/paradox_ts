<?php
return [
    'core.app_dir' => APP_DIR,
    'database.driver' => 'mysql',
    'database.fetch' => PDO::FETCH_CLASS,
    'database.connections' => [
        'mysql' => [
            'driver' => DB_DRIVER,
            'host' => DB_HOST,
            'database' => DB_NAME,
            'port' => DB_PORT,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => DB_CHARSET,
            'collation' => DB_COLLATION,
        ]
    ]
];

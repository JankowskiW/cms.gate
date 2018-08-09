<?php

return [
    'database' => [
        'name' => 'cms',
        'username' => 'root',
        'password' => 'haslo',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];

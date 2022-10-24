<?php

    return [
        'tsystems_tdata_pro' => [
            'driver' => 'mysql',
            'host' => env('TSYSTEMS_TDATA_HOST','-'),
            'port' => env('TSYSTEMS_TDATA_PORT','3306'),
            'database' => env('TSYSTEMS_TDATA_DATABASE','-'),
            'username' =>  env('TSYSTEMS_TDATA_USERNAME','-'),
            'password' =>  env('TSYSTEMS_TDATA_PASSWORD','-'),
            'unix_socket' =>  '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
            'options'   => array(
                PDO::ATTR_CASE => PDO::CASE_NATURAL
            ),
        ]
    ];
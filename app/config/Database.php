<?php
/**
 * Created by PhpStorm.
 * User: longjianghu
 * Date: 2019/2/12
 * Time: 22:52
 */

return [
    'master' => [
        'server'        => '172.17.0.1',
        'username'      => 'root',
        'password'      => 'dev2312',
        'database_type' => 'mysql',
        'database_name' => 'db_user',
        'prefix'        => '',
        'charset'       => 'utf8mb4',
        'collation'     => 'utf8mb4_general_ci',
        'port'          => '3306',
    ],
    'slave'  => [
        'server'        => '172.17.0.1',
        'username'      => 'root',
        'password'      => 'dev2312',
        'database_type' => 'mysql',
        'database_name' => 'db_user',
        'prefix'        => '',
        'charset'       => 'utf8mb4',
        'collation'     => 'utf8mb4_general_ci',
        'port'          => '3306',
    ],
];
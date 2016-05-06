<?php

return [
    'class' => 'yii\db\Connection',
    // 你的数据库连接地址以及数据库名
    'dsn' => 'mysql:host=[Your host:port];dbname=[Your database name]',
    // 用于登录数据库的用户名
    'username' => '',
    // 用于登录数据库的密码
    'password' => '',
    // 数据库字符集
    'charset' => 'utf8',
    // 数据库表名前缀，如果没有可以去掉这一行
    'tablePrefix' => ''
];

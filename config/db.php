<?php

/**
DROP DATABASE IF EXISTS `diglot`;
CREATE DATABASE IF NOT EXISTS `diglot` DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON diglot.* TO diglot_rw@localhost IDENTIFIED BY '123456';
*/

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=diglot',
    'username' => 'diglot_rw',
    'password' => '123456',
    'charset' => 'utf8',
    'enableSchemaCache' => true,
];

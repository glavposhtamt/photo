<?php
$connection = array(
    'host' => 'localhost',
    'user' => 'root',
    'password' => 'mysql',
    'db' => 'photo'
);


$config_db = array( 'development' => 'mysql://' . $connection['user'] .':' . $connection['password'] . '@' . $connection['host'] .'/' . $connection['db'] .';charset=utf8');
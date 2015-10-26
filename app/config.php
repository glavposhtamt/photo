<?php

define('FILES_PATH', $_SERVER['DOCUMENT_ROOT'] . "/files");
define('CROP_PATH', FILES_PATH  . '/.crop');
define('MINI_PATH', FILES_PATH  . '/.mini');
define('WATER_PATH', FILES_PATH  . '/.water');
define('THUMBAIL_PATH', FILES_PATH  . '/.thumbail');
define('CLASS_PATH', $_SERVER['DOCUMENT_ROOT'] . "/app/Class");
define('FILES_URI', $_SERVER['HTTP_HOST'] . '/files');

$connection = array(
    'host' => 'localhost',
    'user' => 'root',
    'password' => 'mysql',
    'db' => 'photo'
);

$options = array(
    'delete_type' => 'POST',
    'db_host' => $connection['host'],
    'db_user' => $connection['user'],
    'db_pass' => $connection['password'],
    'db_name' => $connection['db'],
    'script_url' => 'http://'. $_SERVER['HTTP_HOST'] . '/admin/images',
    'db_table' => 'files',
    'upload_url' => '/files/',
    'upload_dir' => FILES_PATH . '/',
    'bind' => 'bind'
);


$config_db = array( 'development' => 'mysql://' . $connection['user'] .':' . $connection['password'] . '@' . $connection['host'] .'/' . $connection['db'] .';charset=utf8;collation=utf8_general_ci');
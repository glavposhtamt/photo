<?php
define('FILES_PATH', $_SERVER['DOCUMENT_ROOT'] . "/files");
define('CROP_PATH', FILES_PATH  . '/.crop');
define('MINI_PATH', FILES_PATH  . '/.mini');
define('WATER_PATH', FILES_PATH  . '/.water');
define('THUMBAIL_PATH', FILES_PATH  . '/.thumbail');
define('CLASS_PATH', $_SERVER['DOCUMENT_ROOT'] . "/app/Class");
define('FILES_URI', $_SERVER['HTTP_HOST'] . '/files');

require_once 'Routes/routSite.php';
require_once 'Routes/routAdmin.php';
require_once 'Routes/routFile.php';

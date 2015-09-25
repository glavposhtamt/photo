<?php
define('FILES_PATH', $_SERVER['DOCUMENT_ROOT'] . "files");
define('CLASS_PATH', $_SERVER['DOCUMENT_ROOT'] . "app/Class");

require_once 'Routes/routSite.php';
require_once 'Routes/routAdmin.php';
require_once 'Routes/routFile.php';

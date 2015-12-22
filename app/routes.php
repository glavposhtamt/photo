<?php

$js_css = $app->config('js_css');

$authenticate = function ($app) {
    return function () use ($app) {
        if (!isset($_SESSION['user'])) {
            $_SESSION['urlRedirect'] = $app->request()->getPathInfo();
            $app->flash('error', 'Login required');
            $app->redirect('/login');
        }
    };
};

require_once 'Routes/routSite.php';
require_once 'Routes/routAdmin.php';
require_once 'Routes/routFile.php';
require_once 'Routes/routTest.php';

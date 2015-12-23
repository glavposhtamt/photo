<?php

$js_css = $app->config('js_css');

$authenticate = function ($app) {
    return function () use ($app) {
        if (!isset($_SESSION['user'])) {
            $_SESSION['urlRedirect'] = $app->request()->getPathInfo();
            $app->flash('error', 'Login required');
            $app->redirect('/admin/');
        }
    };
};

$app->hook('slim.before.dispatch', function() use ($app) { 
   $user = null;
   if (isset($_SESSION['user'])) {
      $user = $_SESSION['user'];
   }
   $app->view()->setData('user', $user);
});

require_once 'Routes/routSite.php';
require_once 'Routes/routAdmin.php';
require_once 'Routes/routFile.php';
require_once 'Routes/routTest.php';

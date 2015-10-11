<?php
require __DIR__ . '/../Class/MysqlUploadHandler.php';

$connect = $app->config('config_db');

$options = array(
    'delete_type' => 'POST',
    'db_host' => $connect['host'],
    'db_user' => $connect['user'],
    'db_pass' => $connect['password'],
    'db_name' => $connect['db'],
    'script_url' => 'http://'. $_SERVER['HTTP_HOST'] . '/admin/images',
    'db_table' => 'files',
    'upload_url' => '/files/',
    'upload_dir' => $_SERVER['DOCUMENT_ROOT'] . '/files/',
    'bind' => 'bind'
);


$upload_handler = new MysqlUploadHandler($options, FALSE);


$app->get('/admin/images', function() use($app, $upload_handler) {

    $upload_handler->listen();
    
});

$app->post('/admin/images', function() use($app, $upload_handler) {

    $upload_handler->listen();
    
});

$app->delete('/admin/images', function() use($app, $upload_handler) {

    $upload_handler->listen();
    
});

$app->post('/admin/attache', function(){
    $id = $_POST['id'];
    $files = Files::find((int)$id);
    $files->description = $_POST['description'];
    $files->title = $_POST['title'];
    $files->save();
});

$app->post('/admin/newfolder', function(){
    if(!is_dir(FILES_PATH . $_POST['name'])){ mkdir(FILES_PATH . $_POST['name']); }
});

$app->post('/admin/rename', function(){
    die('success!');
});


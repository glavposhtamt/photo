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

$app->get('/admin/scan', function() use($imgCollection) {

// Run the recursive function 
    
    $response = $imgCollection->scan(FILES_PATH);
    $files = Files::find('all', array( 'select' => 'id, name' ));
    $arr = [];
    foreach($files as $key => $value){
        $arr[$value->name] = $value->id;
    }
    
    foreach($response as $key => $value){
        if($value['type'] !== 'folder'){
            $id = $arr[$value['name']];
            $response[$key]['id'] = $id;
        }
    }
    
    header('Content-type: application/json');

    echo json_encode(array(
        "name" => "files",
        "type" => "folder",
        "path" => FILES_PATH,
        "items" => $response,
        "short" => $imgCollection->getShortPath(FILES_PATH)
    ));
});

$app->post('/admin/newfolder', function(){
    if(!is_dir(FILES_PATH . $_POST['name'])){ mkdir(FILES_PATH . $_POST['name']); }
});

$app->post('/admin/rename', function(){

    if(is_file(FILES_PATH . '/' . $_POST['path'])){
        $file = Files::find_by_name($_POST['name']);
        $file->url =  $_POST['newPath'];
        $file->save();
        rename(FILES_PATH . '/' . $_POST['path'], FILES_PATH . '/' . $_POST['newPath']);
    }

});

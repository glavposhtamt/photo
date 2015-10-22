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

$delTree = function ($dirPath) use(&$delTree) {

    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }
    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            $delTree($file);
        } else {
            unlink($file);
        }
    }
    rmdir($dirPath);
  };


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
    
    $files = Files::find('all', array( 'select' => 'id, name' ));
    $arr = [];
    foreach($files as $key => $value){
        $arr[$value->name] = $value->id;
    }
        
    $response = $imgCollection->scan(FILES_PATH, $arr);

    header('Content-type: application/json');

    echo json_encode(array(
        "name" => "files",
        "type" => "folder",
        "path" => FILES_PATH,
        "items" => $response,
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

$app->post('/admin/dropfile', function() use($upload_handler, $delTree){
    if($_POST['type'] === 'folders') {
        $ids = [];
        $full_path = $_POST['path'] . $_POST['name'] . '/';
        $file = Files::find('all', array('select' => 'id, url, name', 'conditions' => array('url LIKE ?', $full_path . '%')));
        
        for($i = 0; $i < count($file); $i++) { 
            array_push($ids, $file[$i]->id);
            $upload_handler->remove_image_water($file[$i]->name);
            $file[$i]->delete();
        }
        
        $binds = Bind::find_all_by_file_id($ids);
        
        for($i = 0; $i < count($binds); $i++) $binds[$i]->delete();
            
        if(is_dir(FILES_PATH . '/' . $full_path)){
            $delTree(FILES_PATH . '/' . $full_path);
        }
        
    } elseif($_POST['type'] === 'files'){
        $full_path = $_POST['path'] . $_POST['name'];
        
        $file = Files::find_by_url($full_path, array('select' => 'id, url, name'));
        
        $bind = Bind::find_by_file_id($file->id);
        
        $upload_handler->remove_image_water($file->name);
        
        $file->delete();
        
        if(is_file(FILES_PATH . '/' . $full_path)){
            unlink(FILES_PATH . '/' . $full_path);
        }
    }
    die('Успех!');
    
});

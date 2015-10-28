<?php
require __DIR__ . '/../Class/MysqlUploadHandler.php';

$connect = $app->config('config_db');

function setUploadOptions($opt){

    if(isset($_COOKIE['path']) && $_COOKIE['path'] !== '' && is_dir(FILES_PATH . '/' . $_COOKIE['path'])){        
        $opt['upload_dir'] = FILES_PATH . '/' . $_COOKIE['path'];
        $opt['upload_url'] .= $_COOKIE['path'];
        //setcookie ('path', '', time() - 3600);
    }
    return $opt;
}

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

$removeThumbnail = function($fileName){
    if(is_file(THUMBAIL_PATH . '/' . $fileName)){
        unlink(THUMBAIL_PATH . '/' . $fileName);
    }
};



$app->get('/admin/images', function() use($app) {
    $options = setUploadOptions($app->config('upload_options'));
    $upload_handler = new MysqlUploadHandler($options, FALSE);
    $upload_handler->listen();    
});

$app->post('/admin/images', function() use($app) {
    $options = setUploadOptions($app->config('upload_options'));
    $upload_handler = new MysqlUploadHandler($options, FALSE);
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
    
    $files = Files::find('all', array( 'select' => 'id, name, url' ));
    $id = []; $url = [];
    foreach($files as $key => $value){
        $id[$value->name] = $value->id;
        $url[$value->name] = is_null($value->url) ? $imgCollection->getShortPath(FILES_PATH . '/' . $value->name) : 'files/' . $value->url;
    }
        
    $response = $imgCollection->scan(FILES_PATH, $id, $url);

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

$app->post('/admin/dropfile', function() use($delTree, $removeThumbnail, $app){
    $upload_handler = new MysqlUploadHandler($app->config('upload_options'), FALSE);
    
    if($_POST['type'] === 'folders') {
        $ids = [];
        $full_path = $_POST['path'] . $_POST['name'] . '/';
        $file = Files::find('all', array('select' => 'id, url, name', 'conditions' => array('url LIKE ?', $full_path . '%')));
        
        for($i = 0; $i < count($file); $i++) { 
            array_push($ids, $file[$i]->id);
            $upload_handler->remove_image_water($file[$i]->name);
            $removeThumbnail($file[$i]->name);
            $file[$i]->delete();
        }
        
        try {
            $binds = Bind::find_all_by_file_id($ids);
        } catch (Exception $e) {
            if(is_dir(FILES_PATH . '/' . $full_path)) $delTree(FILES_PATH . '/' . $full_path);
            die('Успех!');
        }
        
        
        for($i = 0; $i < count($binds); $i++) $binds[$i]->delete();
            
        if(is_dir(FILES_PATH . '/' . $full_path)){
            $delTree(FILES_PATH . '/' . $full_path);
        }
        
    } elseif($_POST['type'] === 'files'){
        $full_path = ($_POST['path']) ? $_POST['path'] . $_POST['name'] : $_POST['name'];

        $file = Files::find_by_name($_POST['name'], array('select' => 'id, url, name', 
                                                          'conditions' => array('url' => ($_POST['path']) ? $_POST['path'] : NULL)));
        
        try{
            $upload_handler->remove_image_water($file->name);
            $removeThumbnail($file->name);
        } catch (Exception $ex) {
            if(is_file(FILES_PATH . '/' . $full_path)){
                unlink(FILES_PATH . '/' . $full_path);
            }
            die();
        }
        
        try {
            $bind = Bind::find_all_by_file_id($file->id);
        } catch (Exception $e) {
            if(is_file(FILES_PATH . '/' . $full_path)) unlink(FILES_PATH . '/' . $full_path);
            $file->delete();
            die('Успех!');
        }   
        
        for($i = 0; $i < count($bind); $i++) $bind[$i]->delete();
        
        $file->delete();
        
        if(is_file(FILES_PATH . '/' . $full_path)){
            unlink(FILES_PATH . '/' . $full_path);
        }
    }
    die('Успех!');
    
});

$app->get('/admin/test', function() use($app){
    $options = $app->config('upload_options');
    $opt = setUploadOptions($options);
    var_dump($opt);   

});

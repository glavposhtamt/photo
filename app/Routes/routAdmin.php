<?php

define('CROP_PATH', 'files/crop/');

use \Eventviva\ImageResize;

require CLASS_PATH . '/ImageProcessingCollection.php';
require CLASS_PATH . '/WatermarkClass.php';

$imgCollection = new ImageProcessingCollection();
$watermark = new WatermarkClass();

$selectAllImg = function (){
    $img = Files::find('all');
    return $img;
};

$addImgThumbnail = function($model, $file_name) {
/*    $model = News::find((int)$model_id, array('select' => 'id, thumbnail'));*/
    if(!is_dir(FILES_PATH . '/mini')){
        if(!mkdir(FILES_PATH . '/mini', 0755)){
            die();
        }
    }

    if($model->id . '_' . $file_name === $model->thumbnail){ return; }
    
    if(is_file(FILES_PATH . '/mini/' . $model->thumbnail)){
        unlink(FILES_PATH . '/mini/' . $model->thumbnail);
    }
    $image = new ImageResize(FILES_PATH . "/$file_name");
    $image->resizeToWidth(700);
    $image->save(FILES_PATH . "/mini/$model->id" . '_' . $file_name);
    $model->thumbnail = $model->id . '_' . $file_name;
    $model->save();
};

$func = function($route){
    $description = '';
    $url_path = parse_url($route, PHP_URL_PATH);
    $uri_parts = explode('/', trim($url_path, ' /'));
    if(count($uri_parts) > 1) {
        $dict = array('kids' => 'Детский альбом', 'student' => 'Студенческий альбом', 'school' => "Школьный альбом", 'minibook' => 'MINIBook');
        foreach ($dict as $key => $value ) {
            if($uri_parts[0] === $key) {
                $description = $value;
            }
        }
    }
    return $description;
    
};

$bindTables = function($table, $id, $addImgThumbnail){
    $i = 0;
    if (isset($_COOKIE['file'])) {
        foreach ($_COOKIE['file'] as $name => $value) {
            if($value !== "") {
                $bind = new Bind();
                $bind->file_name = $value;
                $bind->file_id = (int)$name;
                $bind->setTableId($table, $id);
                $bind->position = $i;
                $bind->save();
                setcookie ("file[$name]", "", time() - 3600, "/admin/");
                if($i === 0){ 
                    if($table === 'news') $model = News::find((int)$bind->news_id, array('select' => 'id, thumbnail'));
                    elseif($table === 'work') $model = Work::find((int)$bind->work_id, array('select' => 'id, thumbnail'));
                    else die("Неверная таблица!");
                    $addImgThumbnail($model, $bind->file_name); 
                }
                $i++;
                
            }
        }
    }
};

$app->get('/admin/', function() use($app) {
	$app->redirect('/admin/news');
});

$app->get('/admin/news/', function() use($app) {
    $list = News::find_by_sql("SELECT id, title, date FROM news");
    $app->render('news.php', array('list' => $list));

});

$app->get('/admin/page', function() use($app, $func) {
        $list = Post::find_by_sql("SELECT id, route, title, date FROM post");  
        
	$app->render('list.php', array('arr' => $list , 'func' => $func));
});

$app->get('/admin/page/:id', function ($id) use($app) {
    $post = Post::find((int)$id);   
    
    $app->render('page.php', array('post' => $post));
});

$app->post('/admin/page/:id', function ($id) use($app) {
    $message = "Страница успешно изменена";
    $post = Post::find((int)$id);
    $post->post = $_POST['editor1'];
    $post->title = $_POST['title'];
    $post->save();
    $app->render('page.php', array('post' => $post, 'message' => $message));
    
});

$app->post('/admin/delete/', function () {
    Bind::deleteRow($_POST['type'], $_POST['id']);
    if(isset($_POST['type']) && $_POST['type'] === 'news'){
        $news = News::find((int)$_POST['id']);
        $news->delete();
        $file_name1 = FILES_PATH . '/mini/' . $news->thumbnail;
        $file_name2 = FILES_PATH . '/crop/' . $news->mini;
        if(is_file($file_name1)) { unlink($file_name1); }
        if(is_file($file_name2)) { unlink($file_name2); }
    }elseif(isset($_POST['type']) && $_POST['type'] === 'work'){
        $news = Work::find((int)$_POST['id']);
        $news->delete();
    }
});

$app->get('/admin/news/add', function () use($app) {
        if (isset($_COOKIE['file'])) {
            foreach ($_COOKIE['file'] as $name => $value) {
                setcookie ("file[$name]", "", time() - 3600, "/admin/");
            }
        }
        $app->render('news_add.php');
});


$app->post('/admin/news/add', function () use ($app, $addImgThumbnail, $bindTables){
    $news = new News();
    $news->title = $_POST["title"];
    $news->anotation = $_POST["anotation"];
    $news->news = $_POST["editor2"];
    $news->keywords = $_POST["keywords"];
    $news->save();
    
    /*связываем новость и картинки*/
    $bindTables('news', $news->id, $addImgThumbnail);
    
    $app->redirect('/admin/thumbnail/news/'. $news->id);
});

$app->get('/admin/news/:id', function ($id) use($app, $selectAllImg) {
    $news = News::find((int)$id);  
    $img = Bind::find_all_by_news_id((int)$id, array('order' => 'position'));
    $gallery = $selectAllImg();
    $app->render('news_edit.php', array('news' => $news, 'images' => $img, 'gallery' => $gallery));
});

$app->post('/admin/news/:id', function ($id) use($app, $selectAllImg) {
    $message = "Новость успешно изменена";
    $newDate = new DateTime($_POST['date']);
    $post = News::find((int)$id);
    $post->news = $_POST['editor1'];
    $post->title = $_POST['title'];
    $post->anotation = $_POST['anotation'];
    $post->date = date_format($newDate, 'Y-m-d H:i:s');
    $post->keywords = $_POST['keywords'];
    $post->save();
    $img = Bind::find_all_by_news_id((int)$id, array('order' => 'position'));
    $gallery = $selectAllImg();
    $app->render('news_edit.php', array('news' => $post, 'message' => $message, 'images' => $img, 'gallery' => $gallery));
    
});

$app->get('/admin/settings', function() use($app, $selectAllImg) {
    $gallery = $selectAllImg();
    $count = Watermark::num_rows();
    if($count === 1){ 
        $water = Watermark::find(1);
        if(!is_file(FILES_PATH . '/' . $water->file_name)){
            $water->delete();
            $wi = FALSE;
        }else {
            $wi = $water->file_name;
        }
    }  else {
        $wi = FALSE;
    }
    
    $app->render('settings.php', array('gallery' => $gallery, 'file_name' => $wi));
});

$app->get('/admin/gallery', function() use($app) {

    $app->render('images.php');
});

$app->get('/admin/test', function() {

});

$app->post('/admin/position/', function() use($addImgThumbnail){
    $pos = json_decode($_POST['position']);
    $arr = get_object_vars($pos);
    $bind = Bind::find_all_by_news_id((int)$pos->id, array('select' => 'position, file_id, id, file_name'));
    
        
    for($i = 0; $i < count($bind); ++$i){
        $bind[$i]->position = (int)$arr[(int)$bind[$i]->file_id];
        $bind[$i]->save();
        if($bind[$i]->position === 0) {
            $model = News::find((int)$pos->id, array('select' => 'id, thumbnail'));
            $addImgThumbnail($model, $bind[$i]->file_name);
        }
    }

});

$app->post('/admin/bind', function(){
    $bind = new Bind();
    $bind->file_id = (int)$_POST['file_id'];
    $bind->file_name = $_POST['file_name'];
    $bind->news_id = $_POST['id'];
    $bind->save();
    die(1);
    
});

$app->post('/admin/removeimg', function(){
    $id =  $_POST['file_id'];
    $bind = Bind::find_by_file_id((int)$id);
    $bind->delete();
    echo $id;
    
});

$app->get('/admin/thumbnail/news/:id', function($id) use($app) {
    $thumb = News::find((int)$id, array('select' => 'thumbnail, id, mini'));
    $app->render('thumbnail.php', array('news' => $thumb));      
});

$app->get('/admin/thumbnail/work/:id', function($id) use($app) {
    $thumb = Work::find((int)$id, array('select' => 'thumbnail, id, mini'));
    $app->render('thumbnail.php', array('news' => $thumb));      
});

$app->post('/admin/thumbnail/:id', function($id) use($imgCollection) {
    if(!is_dir(FILES_PATH . '/crop')){
        if(!mkdir(FILES_PATH . '/crop', 0755)){
            die();
        }
    }
    $thumb = News::find((int)$id, array('select' => 'thumbnail, mini, id'));
    $x1 = $_POST['x1'];
    $x2 = $_POST['x2'];
    $y1 = $_POST['y1'];
    $y2 = $_POST['y2'];
    $img = $_SERVER["DOCUMENT_ROOT"] . "/" . $_POST['img'];
    $full_patch = $_SERVER['DOCUMENT_ROOT'] . "/" . CROP_PATH;
    
    if(!is_null($thumb->mini)){
        unlink($full_patch . $thumb->mini);
    }
    
    $arr = pathinfo($thumb->thumbnail);
    $cropName = $arr['filename'] . time() . $arr['extension'];
    
    $imgCollection->crop( $img, $full_patch . $cropName, array($x1, $y1, $x2, $y2));
    $thumb->mini = $cropName;
    $thumb->save();
    die(CROP_PATH . $cropName);
});

$app->get('/admin/watermark/:id', function($id) use($watermark){
    $img = Bind::find_all_by_news_id((int)$id, array('select' => 'file_name'));
    $count_img = Bind::num_rows();
    if($count_img === 0){ die("В этой новости нету картинок!"); }
    $count = Watermark::num_rows();
    if($count === 0){ die("Не установлен логотип!"); }
    $water = Watermark::find(1);
    if(!is_dir(FILES_PATH . '/water')){
        if(!mkdir(FILES_PATH . '/water', 0755)){
            die("Не могу создать папку!");
        }
    }
    if(!is_file(FILES_PATH . '/' . $water->file_name)){
            $water->delete();
            die("Логотип был удалён!");
    }
    $img_path = $_SERVER['DOCUMENT_ROOT'] . '/files/';
    $img_water_path = $_SERVER['DOCUMENT_ROOT'] . '/files/water/';
    foreach ($img as $file_name){
        $arr = explode('.', $file_name->file_name);
        array_pop($arr);
        $water_str = implode('.', $arr);
        $img_full_water_name = $img_water_path . $water_str . '.jpg';
        $img_full_name = $img_path . $file_name->file_name;
        $wi = $img_path . $water->file_name;
        $watermark->apply($img_full_name, $img_full_water_name, $wi, 3);
    }
    die("Водяные знаки успешно установлены!");
});

$app->post('/admin/setwatermark/', function(){
    $count = Watermark::num_rows();
    if($count === 0){
        $watermark = new Watermark();
        $watermark->id = 1;
        $watermark->file_name = $_POST['file_name'];
        $watermark->file_id = (int)$_POST['file_id'];
        $watermark->save();
    } elseif ($count === 1) {
        $watermark = new Watermark();
        $watermark->id = 1;
        $watermark = Watermark::find(1);
        $watermark->file_name = $_POST['file_name'];
        $watermark->file_id = (int)$_POST['file_id'];
        $watermark->save();
    } else {
        die(-1);
    } 
});

$app->get('/admin/work/', function() use($app) {
    $list = Work::find_by_sql('SELECT work.id, title, city FROM work INNER JOIN institution ON work.institution = institution.id');
	$app->render('work.php', array('list' => $list));

});

$app->get('/admin/institution/', function() use($app) {
    $inst = Institution::find('all');
    $count = Institution::num_rows();
    $city = Institution::get_unique_cityes();  

    $app->render('institution.php', array('inst' => $inst ,'city' => $city, 'count' => $count ));

});

$app->post('/admin/institution/', function() use($app) {

    $type = (int)$_POST['type'];
    if($type > 0 && $type < 4 ){
        $inst = new Institution();
        $inst->title = $_POST['title'];
        $inst->street = $_POST['street'];
        $inst->type = $type;
        if($_POST['other-city'] === '' && $_POST['city'] !== '' && $_POST['city'] !== 'Другой вариант'){ 
            $inst->city = $_POST['city'];
        }elseif ($_POST['other-city'] !== '') {
            $inst->city = $_POST['other-city'];
        }  else {
            $app->redirect('/admin/institution/');
        }
        $inst->save();
    } else {
        $app->redirect('/admin/institution/');
    }
    $app->redirect('/admin/institution/success/'); 

});

$app->get('/admin/institution/success/', function() use($app) {
    $count = Institution::num_rows();
    $inst = Institution::find('all');
    $city = Institution::get_unique_cityes();
    $app->render('institution.php', array('inst' => $inst, 'city' => $city, 'message' => "Учебное заведение успешно добавлено!", 'count' => $count));

});

$app->get('/admin/work/add', function() use($app){
    $school = Institution::find('all', array('select' => 'DISTINCT city', 'conditions' => array('type' => 'Школа')));
    $app->render("work_add.php", array('school' => $school));
});

$app->post('/admin/smartform/', function(){
    if(isset($_POST['query']) && $_POST['query'] === 'city'){
        $city = Institution::all(array('select' => 'DISTINCT city', 'conditions' => array('type' => $_POST['type'])));
        $arr = []; $i = 0;
        foreach($city as $value){
            $arr[$i] = $value->city;
            $i++;
        }
        die(json_encode($arr)); 
    }
    
    if(isset($_POST['query']) && $_POST['query'] === 'institution'){
        $inst = Institution::all(array('select' => 'id, title', 'conditions' => array('type' => $_POST['type'], 
                                                                                           'city' => $_POST['city'])));
        $arr = [];
        foreach($inst as $value) $arr[$value->id] = $value->title;
 
        die(json_encode($arr));
    }
    
});

$app->post('/admin/work/add', function() use($app, $addImgThumbnail, $bindTables){

    $work = new Work();
    if(isset($_POST['institution'])) $work->institution = (int)$_POST['institution'];
    else return;
    if(isset($_POST['work-class'])) $work->school_class = $_POST['work-class'];
    $work->year = $_POST['work-year'];
    $work->anotation = $_POST['work-desc'];
    $work->keywords = $_POST['work-keywords'];
    $work->save();
    $bindTables('work', $work->id, $addImgThumbnail);
    $app->redirect('/admin/thumbnail/work/'. $work->id);
    
});

$app->get('/admin/work/:id', function($id) use($app){
    $app->render('work_edit.php');
});
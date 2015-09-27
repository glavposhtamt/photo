<?php

use \Eventviva\ImageResize;

require CLASS_PATH . '/ImageProcessingCollection.php';
require CLASS_PATH . '/WatermarkClass.php';

$imgCollection = new ImageProcessingCollection();
$watermark = new WatermarkClass();

$selectAllImg = function (){
    $img = Files::find('all');
    return $img;
};

$addImgThumbnail = function($file_name, $news_id) {
    if(!is_dir(FILES_PATH . '/mini')){
        if(!mkdir(FILES_PATH . '/mini', 0755)){
            die();
        }
    }
    
    $news = News::find((int)$news_id, array('select' => 'id, thumbnail'));
    if($news_id . '_' . $file_name === $news->thumbnail){ return; }
    
    if(is_file(FILES_PATH . '/mini/' . $news->thumbnail)){
        unlink(FILES_PATH . '/mini/' . $news->thumbnail);
    }
    $image = new ImageResize(FILES_PATH . "/$file_name");
    $image->resizeToWidth(700);
    $image->save(FILES_PATH . "/mini/$news_id" . '_' . $file_name);
    $news->thumbnail = $news_id . '_' . $file_name;
    $news->save();
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

$app->get('/admin/news/delete/:id', function ($id) {
    $news = News::find((int)$id);
    $news->delete();
    Bind::delete_all(array('conditions' => array('news_id' => (int)$id)));
    $file_name1 = FILES_PATH . '/mini/' . $news->thumbnail;
    $file_name2 = FILES_PATH . '/crop/' . $news->mini;
    if(is_file($file_name1)) { unlink($file_name1); }
    if(is_file($file_name2)) { unlink($file_name2); }

    echo $id;
});

$app->get('/admin/news/add', function () use($app) {
        if (isset($_COOKIE['file'])) {
            foreach ($_COOKIE['file'] as $name => $value) {
                setcookie ("file[$name]", "", time() - 3600, "/admin/");
            }
        }
        $app->render('news_add.php');
});


$app->post('/admin/news/add', function () use ($app, $addImgThumbnail){
    $i = 0;
    $file_id;
    $news = new News();
    $news->title = $_POST["title"];
    $news->anotation = $_POST["anotation"];
    $news->news = $_POST["editor2"];
    $news->keywords = $_POST["keywords"];
    $news->save();
    
    /*связываем новость и картинки*/
    
    if (isset($_COOKIE['file'])) {
        foreach ($_COOKIE['file'] as $name => $value) {
            if($value !== "") {
                $bind = new Bind();
                $bind->file_name = $value;
                $bind->file_id = (int)$name;
                $bind->news_id = (int)$news->id;
                $bind->position = $i;
                $bind->save();
                setcookie ("file[$name]", "", time() - 3600, "/admin/");
                if($i === 0) $addImgThumbnail($bind->file_name, $bind->news_id);
                $i++;
                
            }
        }
}
    
    $app->redirect('/admin/thumbnail/'. $news->id);
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
//    var_dump(FILES_PATH);
//    var_dump(CLASS_PATH);
    $obj = Institution::get_unique_sityes();
    var_dump($obj);
});

$app->post('/admin/position/', function() use($addImgThumbnail){
    $pos = json_decode($_POST['position']);
    $arr = get_object_vars($pos);
    $bind = Bind::find_all_by_news_id((int)$pos->id, array('select' => 'position, file_id, id, file_name'));
    
        
    for($i = 0; $i < count($bind); ++$i){
        $bind[$i]->position = (int)$arr[(int)$bind[$i]->file_id];
        $bind[$i]->save();
        if($bind[$i]->position === 0) { $addImgThumbnail($bind[$i]->file_name, (int)$pos->id); }
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

$app->get('/admin/thumbnail/:id', function($id) use($app) {
    $thumb = News::find((int)$id, array('select' => 'thumbnail, id'));
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
    $patch = $_POST['crop'];
    $full_patch = $_SERVER['DOCUMENT_ROOT'] . "/" . $patch;
    if(!is_null($thumb->mini)){
        unlink($full_patch . $thumb->mini);
    }
    $imgCollection->crop( $img, $full_patch . $thumb->thumbnail, array($x1, $y1, $x2, $y2));
    $thumb->mini = $thumb->thumbnail;
    $thumb->save();
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
        $list = News::find_by_sql("SELECT id, title, date FROM news");
	$app->render('work.php', array('list' => $list));

});

$app->get('/admin/institution/', function() use($app) {
    $inst = Institution::find('all');
    $sity = Institution::get_unique_sityes();    
    $app->render('institution.php', array('inst' => $inst ,'sity' => $sity ));

});

$app->post('/admin/institution/', function() use($app) {

    $type = (int)$_POST['type'];
    if($type > 0 && $type < 4 ){
        $inst = new Institution();
        $inst->title = $_POST['title'];
        $inst->type = $type;
        if($_POST['other-sity'] === '' && $_POST['sity'] !== '' && $_POST['sity'] !== 'Другой вариант'){ 
            $inst->sity = $_POST['sity'];
        }elseif ($_POST['other-sity'] !== '') {
            $inst->sity = $_POST['other-sity'];
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

    $inst = Institution::find('all');
    $sity = Institution::get_unique_sityes();
    $app->render('institution.php', array('inst' => $inst, 'sity' => $sity, 'message' => "Учебное заведение успешно добавлено!"));

});

$app->get('/admin/work/add/', function() use($app){
    
    $app->render("work_add.php");
});
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

$addImgThumbnail = function($model, $file_name) {
/*    $model = News::find((int)$model_id, array('select' => 'id, thumbnail'));*/
    if(!is_dir(MINI_PATH)){
        if(!mkdir(MINI_PATH, 0755)){
            die();
        }
    }

    if($model->id . '_' . $file_name === $model->thumbnail){ return; }
    
    if(is_file(MINI_PATH . '/' . $model->thumbnail)){
        unlink(MINI_PATH . '/' . $model->thumbnail);
    }
    $url = Files::find_by_name($file_name, array('select' => 'url'));
    $path = ($url->url) ? FILES_PATH . '/' . $url->url : FILES_PATH . "/$file_name";
    $image = new ImageResize($path);
    try{
        $image->resizeToWidth(700);
        $image->save(MINI_PATH . "/$model->id" . '_' . $file_name);
    }
    catch(Exception $e){
        die($e->getMessage());
    }
    
    
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
    $remove = function($model){
        $model->delete();
        $file_name1 = MINI_PATH . '/' . $model->thumbnail;
        $file_name2 = CROP_PATH . '/' . $model->mini;
        if(is_file($file_name1)) { unlink($file_name1); }
        if(is_file($file_name2)) { unlink($file_name2); }
    };
    if(isset($_POST['type']) && $_POST['type'] === 'news') $model = News::find((int)$_POST['id']);
    elseif(isset($_POST['type']) && $_POST['type'] === 'work') $model = Work::find((int)$_POST['id']);
    else die();
    $remove($model);

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
    $app->render('news_edit.php', array('news' => $news, 'images' => $img, 'gallery' => $gallery, 'id' => $news->id));
});

$app->post('/admin/news/:id', function ($id) use($app, $selectAllImg) {
    $message = "Новость успешно изменена";
    $newDate = new DateTime($_POST['date']);
    $post = News::find((int)$id);
    $post->news = $_POST['editor1'];
    $post->title = $_POST['title'];
    $post->anotation = trim($_POST['anotation']);
    $post->date = date_format($newDate, 'Y-m-d H:i:s');
    $post->keywords = $_POST['keywords'];
    $post->save();
    $img = Bind::find_all_by_news_id((int)$id, array('order' => 'position'));
    $gallery = $selectAllImg();
    $app->render('news_edit.php', array('news' => $post, 'message' => $message, 'images' => $img, 'gallery' => $gallery,
                                        'id' => $post->id));
    
});

$app->get('/admin/settings', function() use($app, $selectAllImg) {
    $gallery = $selectAllImg();
    $count = Watermark::num_rows();
    if($count === 1){ 
        
        $water = Watermark::find(1);
        
        $url = Files::find_by_id($water->file_id, array('select' => 'url'));
        if(!empty($url)) $path = ($url->url) ? FILES_PATH . '/' . $url->url : FILES_PATH . "/$water->file_name";
        else $path = '';
        
            
        if(!is_file($path)){
            $water->delete();
            $wi = FALSE;
        }else {
            $wi = ($url->url) ? $url->url : $water->file_name;
        }
    }  else {
        $wi = FALSE;
    }
    
    $app->render('settings.php', array('gallery' => $gallery, 'file_name' => $wi));
});

$app->get('/admin/gallery', function() use($app) {

    $app->render('gallery.php');
});

$app->get('/admin/upload', function() use($app) {

    $app->render('images.php');
});


$app->post('/admin/position/', function() use($addImgThumbnail){
    $pos = json_decode($_POST['position']);
    $arr = get_object_vars($pos);
    
    $model = null;
    if($_POST['type'] === 'news') {
        $bind = Bind::find_all_by_news_id((int)$pos->id, array('select' => 'position, file_id, id, file_name'));
        $model = News::find((int)$pos->id, array('select' => 'id, thumbnail'));
    }
    elseif($_POST['type'] === 'work') {
        $bind = Bind::find_all_by_work_id((int)$pos->id, array('select' => 'position, file_id, id, file_name'));
        $model = Work::find((int)$pos->id, array('select' => 'id, thumbnail'));
    }
    else die();
    
    for($i = 0; $i < count($bind); ++$i){
        $bind[$i]->position = (int)$arr[(int)$bind[$i]->file_id];
        $bind[$i]->save();
        if($bind[$i]->position === 0 && !is_null($model)) $addImgThumbnail($model, $bind[$i]->file_name);

    }

});

$app->post('/admin/bind', function(){
    $bind = new Bind();
    $bind->file_id = (int)$_POST['file_id'];
    $bind->file_name = $_POST['file_name'];
    $bind->setTableId($_POST['type'], $_POST['id']);
    $bind->save();
    die($_POST['id']);
    
});

$app->post('/admin/removeimg', function(){
    $id =  $_POST['file_id'];
    $bind = Bind::find_by_file_id((int)$id);
    $bind->delete();
    echo $id;
    
});

$app->get('/admin/thumbnail/news/:id', function($id) use($app) {
    $thumb = News::find((int)$id, array('select' => 'thumbnail, id, mini'));
    $app->render('thumbnail.php', array('news' => $thumb, 'return' => '/news/' . $thumb->id));      
});

$app->get('/admin/thumbnail/work/:id', function($id) use($app) {
    $thumb = Work::find((int)$id, array('select' => 'thumbnail, id, mini'));
    $app->render('thumbnail.php', array('news' => $thumb, 'return' => '/work/' . $thumb->id . '/edit'));      
});

$app->post('/admin/thumbnail/:id', function($id) use($imgCollection) {
    if(!is_dir(CROP_PATH)){
        if(!mkdir(CROP_PATH, 0755)){
            die();
        }
    }
    $type = $_POST['type'];
    if($type === 'news') $thumb = News::find((int)$id, array('select' => 'thumbnail, mini, id'));
    elseif($type === 'work') $thumb = Work::find((int)$id, array('select' => 'thumbnail, mini, id'));
    $x1 = $_POST['x1'];
    $x2 = $_POST['x2'];
    $y1 = $_POST['y1'];
    $y2 = $_POST['y2'];
    $img = $_SERVER["DOCUMENT_ROOT"] . "/" . $_POST['img'];
    
    if(!is_null($thumb->mini)){
        unlink(CROP_PATH . '/' . $thumb->mini);
    }
    
    $arr = pathinfo($thumb->thumbnail);
    $cropName = $arr['filename'] . time() . '.' . $arr['extension'];
    
    $imgCollection->crop( $img, CROP_PATH . '/' . $cropName, array($x1, $y1, $x2, $y2));
    $thumb->mini = $cropName;
    $thumb->save();
    die( 'files/.crop/' . $cropName);
});

$app->post('/admin/watermark/:id', function($id) use($watermark){
    $count_img = Bind::num_rows();
    if($_POST['type'] === 'news')
        $img = Bind::find_all_by_news_id((int)$id, array('select' => 'file_name'));
    elseif($_POST['type'] === 'work')
        $img = Bind::find_all_by_work_id((int)$id, array('select' => 'file_name'));
    else die();
    if($count_img === 0){ die("Нечего подписывать!"); }
    $count = Watermark::num_rows();
    if($count === 0){ die("Не установлен логотип!"); }
    $water = Watermark::find(1);
    if(!is_dir( WATER_PATH )){
        if(!mkdir(WATER_PATH , 0755)){
            die("Не могу создать папку!");
        }
    }
    
    $files = Files::find('all', array('select' => 'name, url'));
    
    if(empty($files)) die('Происходит что-то невероятное :-D ');
    
    
    $fNames = [];

    foreach($files as $value){
        $fNames[$value->name] = $value->url;
    }
    
    if(!is_file(FILES_PATH . '/' . $water->file_name) && !isset($fNames[$water->file_name])) {
            $water->delete();
            die("Логотип был удалён!");
    }

    $wi = isset($fNames[$water->file_name]) ? FILES_PATH  . '/' . $fNames[$water->file_name] : FILES_PATH  . '/' . $water->file_name;
    
    foreach ($img as $file_name){
        $arr = explode('.', $file_name->file_name);
        array_pop($arr);
        $water_str = implode('.', $arr);
        $img_full_water_name = WATER_PATH . '/' . $water_str . '.jpg';
        
        $img_full_name = isset($fNames[$file_name->file_name]) ? FILES_PATH . '/' . $fNames[$file_name->file_name] : 
                         FILES_PATH . '/' . $file_name->file_name;
        try{
            $watermark->apply($img_full_name, $img_full_water_name, $wi, 3);
        }
        catch (Exception $e) {
            continue;
        }
        
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

$app->get('/admin/getwatername', function(){
    try{
        $name = Files::find((int)$_GET['id']);
    }
    catch (Exception $e){
        die();
    }
    die($name->url);
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
        $city = Institution::all(array('select' => 'DISTINCT city', 'conditions' => array('type' => trim($_POST['type']))));
        $arr = []; $i = 0;
        foreach($city as $value){
            $arr[$i] = $value->city;
            $i++;
        }
        die(json_encode($arr)); 
    }
    
    if(isset($_POST['query']) && $_POST['query'] === 'institution'){
        $inst = Institution::all(array('select' => 'id, title',
                                       'conditions' => array('type' => trim($_POST['type']), 'city' => trim($_POST['city']))));
        
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

$app->get('/admin/work/:id/:succes', function($id, $succes) use($app, $selectAllImg){
    $types = ['Школа', 'ВУЗ', 'Детский сад'];
    
    $list = Work::find_by_sql('SELECT work.id, title, school_class, type, year, city, anotation, work.institution, keywords FROM work INNER JOIN institution ON work.institution = institution.id WHERE work.id = ' . $id);
    
    $list = $list[0];
    
    $city = Institution::find('all', array('select' => 'DISTINCT city', 'conditions' => array('type = ? AND city NOT IN (?)',
                                                                                              $list->type, $list->city)));
    $inst = Institution::find('all', array('select' => 'id, title',
            'conditions' => array('id NOT IN (?) AND type = ? AND city = ?', $list->institution, $list->type, $list->city )));
    
    $img = Bind::find_all_by_work_id((int)$id, array('order' => 'position'));
    $gallery = $selectAllImg();
    if($succes === 'success') $message = 'Работа успешно сохранена!';
    else $message = '';
    $app->render('work_edit.php', array('work' => $list,'school' => $city, 'images' => $img, 'gallery' => $gallery, 
                                        'types' => $types, 'inst' => $inst, 'message' => $message, 'id' => $list->id ));
});

$app->post('/admin/remove/institution', function(){
    $inst = Institution::find((int)$_POST['id']);
    Work::remove((int)$_POST['id']);
    $inst->delete();
    die('Успех!');
});

$app->post('/admin/work/:id/:edit', function($id) use($app) {
    $work = Work::find((int)$id);
    if(isset($_POST['institution'])) $work->institution = (int)$_POST['institution'];
    else return;
    if(isset($_POST['work-class'])) $work->school_class = $_POST['work-class'];
    $work->year = $_POST['work-year'];
    $work->anotation = $_POST['work-desc'];
    $work->keywords = $_POST['work-keywords'];
    $work->save();
    $app->redirect('/admin/work/'. $id . '/success');
});

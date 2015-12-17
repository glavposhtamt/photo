<?php

use \Eventviva\ImageResize;

require CLASS_PATH . '/WatermarkClass.php';

$watermark = new WatermarkClass();

$selectAllImg = function (){
    $img = Files::find('all');
    return $img;
};

$addImgThumbnail = function($postType, $id) {

	switch($postType){
		case 'news': {
			$bind = Bind::find_by_news_id($id, array('select' => 'file_name', 'limit' => 1, 'order' => 'position' ));
			$file_name = $bind->file_name;
			
			$model = News::find($id, array('select' => 'thumbnail, id, mini'));
			
			break;
		}
															  
		case 'work':  {
			$bind = Bind::find_by_work_id($id, array('select' => 'file_name', 'limit' => 1, 'order' => 'position' ));
			$file_name = $bind->file_name;
			
			$model = Work::find($id, array('select' => 'thumbnail, id, mini'));
			
			break;
		}
		default:
			die();
	}
	
	
	
    if(!is_dir(MINI_PATH)){
        if(!mkdir(MINI_PATH, 0755)){
            die();
        }
    }

 
    if($model->id . '_' . $file_name === $model->thumbnail){ return $model; }
    
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
    
    
    
    return $model;
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

$temp2bind = function($table, $id){
	$i = 0;
	$temp = Temp::find('all', array('conditions' => array('type = ?', $table)));
	if($temp){
		foreach($temp as $value){
			$bind = new Bind();
			$bind->file_name = $value->file_name;
			$bind->file_id = $value->file_id;
			$bind->setTableId($table, $id);
			$bind->position = $i;
			$bind->save();
			
            $i++;
		}
	}
};

$app->get('/admin/', function() use($app) {
	$app->redirect('/admin/news');
});

$app->get('/admin/news/', function() use($app, $js_css) {
    $list = News::find_by_sql("SELECT id, title, date FROM news");
    $app->render('admin/news.php', array('list' => $list, 'jsCSSLibs' => $js_css));

});

$app->get('/admin/page', function() use($app, $func, $js_css) {
    $list = Post::find_by_sql("SELECT id, route, title, date FROM post");  
    $app->render('admin/list.php', array('arr' => $list , 'func' => $func, 'jsCSSLibs' => $js_css));
});

$app->get('/admin/page/:id', function ($id) use($app, $js_css) {
    $post = Post::find((int)$id);   
    
    $app->render('admin/page.php', array('post' => $post, 'jsCSSLibs' => $js_css));
});

$app->post('/admin/page/:id', function ($id) use($app, $js_css) {
    $message = "Страница успешно изменена";
    $post = Post::find((int)$id);
    $post->post = $_POST['editor1'];
    $post->title = $_POST['title'];
    $post->save();
    $app->render('admin/page.php', array('post' => $post, 'message' => $message, 'jsCSSLibs' => $js_css));
    
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

$app->get('/admin/news/add', function () use($app, $js_css) {
 
        Temp::delete_all(array('conditions' => array('type' => 'news')));
        $app->render('admin/news_add.php', array('jsCSSLibs' => $js_css));
});


$app->post('/admin/news/add', function () use ($app, $temp2bind){
    $news = new News();
    $news->title = $_POST["title"];
    $news->anotation = $_POST["anotation"];
    $news->news = $_POST["editor2"];
    $news->keywords = $_POST["keywords"];
    $news->save();
    
    /*связываем новость и картинки*/
    $temp2bind('news', $news->id);
    
    $app->redirect('/admin/thumbnail/news/'. $news->id);
});

$app->get('/admin/news/:id', function ($id) use($app, $selectAllImg, $js_css) {
    $news = News::find((int)$id);  
    $img = Bind::find_all_by_news_id((int)$id, array('order' => 'position'));
    $gallery = $selectAllImg();
    $app->render('admin/news_edit.php', array('news' => $news, 'images' => $img, 'gallery' => $gallery, 
                                              'id' => $news->id, 'jsCSSLibs' => $js_css));
});

$app->post('/admin/news/:id', function ($id) use($app, $selectAllImg, $js_css) {
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
    $app->render('admin/news_edit.php', array('news' => $post, 'message' => $message, 'images' => $img, 'gallery' => $gallery,
                                              'id' => $post->id, 'jsCSSLibs' => $js_css));
    
});

$app->get('/admin/settings', function() use($app, $selectAllImg, $js_css) {
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
    
    $app->render('admin/settings.php', array('gallery' => $gallery, 'file_name' => $wi, 'jsCSSLibs' => $js_css));
});

$app->get('/admin/gallery', function() use($app, $js_css) {
    
    $app->render('admin/gallery.php', array('jsCSSLibs' => $js_css));
});

$app->get('/admin/upload', function() use($app, $js_css) {

    $app->render('admin/images.php', array('jsCSSLibs' => $js_css));
});


$app->post('/admin/position/', function() use($addImgThumbnail) {
    $pos = json_decode($_POST['position']);
    $arr = get_object_vars($pos);
    
    if($_POST['type'] === 'news') {
        $bind = Bind::find_all_by_news_id((int)$pos->id, array('select' => 'position, file_id, id, file_name'));
    }
    elseif($_POST['type'] === 'work') {
        $bind = Bind::find_all_by_work_id((int)$pos->id, array('select' => 'position, file_id, id, file_name'));
    }
    else die();
    
    if($bind){
        for($i = 0; $i < count($bind); ++$i){
            $bind[$i]->position = (int)$arr[(int)$bind[$i]->file_id];
            $bind[$i]->save();
         }
        $addImgThumbnail($_POST['type'], $pos->id);
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
    if($bind) $bind->delete();
    echo $id;
    
});

$app->get('/admin/thumbnail/news/:id', function($id) use($app, $addImgThumbnail, $js_css) {
	
	$thumb = $addImgThumbnail('news', $id);

    $app->render('admin/thumbnail.php', array('news' => $thumb, 'return' => '/news/' . $thumb->id, 'jsCSSLibs' => $js_css));      
});

$app->get('/admin/thumbnail/work/:id', function($id) use($app, $addImgThumbnail, $js_css) {
    
    $thumb = $addImgThumbnail('work', $id);
    
    $app->render('admin/thumbnail.php', array('news' => $thumb, 'return' => '/work/' . $thumb->id . '/edit', 
                                              'jsCSSLibs' => $js_css));      
});

$app->post('/admin/thumbnail/:id', function($id) {
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
    
    crop( $img, CROP_PATH . '/' . $cropName, array($x1, $y1, $x2, $y2));
    
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

    $wi = isset($fNames[$water->file_name]) ? FILES_PATH  . '/' . $fNames[$water->file_name] 
                                            : FILES_PATH  . '/' . $water->file_name;
    
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

$app->get('/admin/work/', function() use($app, $js_css) {
    $list = Work::find_by_sql('SELECT work.id, title, city FROM work INNER JOIN institution ON work.institution = institution.id');
	$app->render('admin/work.php', array('list' => $list, 'jsCSSLibs' => $js_css));

});

$app->get('/admin/institution/', function() use($app, $js_css) {
    $inst = Institution::find('all');
    $count = Institution::num_rows();
    $city = Institution::get_unique_cityes();  

    $app->render('admin/institution.php', array('inst' => $inst ,'city' => $city, 'count' => $count, 'jsCSSLibs' => $js_css));

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

$app->get('/admin/institution/success/', function() use($app, $js_css) {
    $count = Institution::num_rows();
    $inst = Institution::find('all');
    $city = Institution::get_unique_cityes();
    $app->render('admin/institution.php', array('inst' => $inst, 'city' => $city, 'message' => "Учебное заведение успешно добавлено!", 'count' => $count, 'jsCSSLibs' => $js_css));

});

$app->get('/admin/work/add', function() use($app, $js_css){
    Temp::delete_all(array('conditions' => array('type' => 'work')));
    
    $school = Institution::find('all', array('select' => 'DISTINCT city', 'conditions' => array('type' => 'Школа')));
    $app->render("admin/work_add.php", array('school' => $school, 'jsCSSLibs' => $js_css));
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

$app->post('/admin/work/add', function() use($app, $temp2bind){
    
    $work = new Work();
    if(isset($_POST['institution'])) $work->institution = (int)$_POST['institution'];
    else return;
    if(isset($_POST['work-class'])) $work->school_class = $_POST['work-class'];
    $work->year = $_POST['work-year'];
    $work->anotation = $_POST['work-desc'];
    $work->keywords = $_POST['work-keywords'];
    $work->save();

    /*связываем новость и картинки*/
    $temp2bind('work', $work->id);

    $app->redirect('/admin/thumbnail/work/'. $work->id);
    
});

$app->get('/admin/work/:id/:succes', function($id, $succes) use($app, $selectAllImg, $js_css){
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
    $app->render('admin/work_edit.php', array('work' => $list,'school' => $city, 'images' => $img, 'gallery' => $gallery, 
                                        'types' => $types, 'inst' => $inst, 'message' => $message, 'id' => $list->id, 
                                        'jsCSSLibs' => $js_css ));
    
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

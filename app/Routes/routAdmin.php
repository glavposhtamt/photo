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
			if($bind) $file_name = $bind->file_name;
            else return null;
			
			$model = News::find($id, array('select' => 'thumbnail, id, mini'));
			
			break;
		}
															  
		case 'work':  {
			$bind = Bind::find_by_work_id($id, array('select' => 'file_name', 'limit' => 1, 'order' => 'position' ));
			if($bind) $file_name = $bind->file_name;
            else return null;
			
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


$app->get("/admin/logout/", function () use ($app) {
   unset($_SESSION['user']);
   $app->view()->setData('user', null);
   $app->redirect('/admin/');
});

$app->get('/admin/', function() use($app, $js_css) {
    
    if($app->view()->getData('user')) $app->redirect('/admin/news');
    
    $flash = $app->view()->getData('flash');
    $error = '';
    
    if (isset($flash['error'])) {
       $error = $flash['error'];
    }
    
    $urlRedirect = '/';
    if ($app->request()->get('r') && $app->request()->get('r') != '/admin/') {
       $_SESSION['urlRedirect'] = $app->request()->get('r');
    }
    
    if (isset($_SESSION['urlRedirect'])) {
       $urlRedirect = $_SESSION['urlRedirect'];
    }
    
    $email_error = '';
    
    if (isset($flash['errors']['user'])) {
       $email_error = $flash['errors']['user'];
    }
    
    
    $app->render('login.php', array('jsCSSLibs' => $js_css, 'email_error' => $email_error));
});

$app->post("/admin/", function () use ($app) {
    $email = $app->request()->post('email');
    $password = $app->request()->post('password');

    $errors = array();

    User::create_default_user();
    
    if (!User::check_pass($email, $password)) {
        $errors['user'] = "Пользователь не существует, либо неверный пароль";
    }

    if (count($errors) > 0) {
        $app->flash('errors', $errors);
        $app->redirect('/admin/');
    }

    $_SESSION['user'] = $email;

    if (isset($_SESSION['urlRedirect'])) {
       $tmp = $_SESSION['urlRedirect'];
       unset($_SESSION['urlRedirect']);
       $app->redirect($tmp);
    }

    $app->redirect('/admin/news');
});

$app->get('/admin/news/', $authenticate($app), function() use($app, $js_css) {
    $list = News::find_by_sql("SELECT id, title, date FROM news");
    $app->render('admin/news.php', array('list' => $list, 'jsCSSLibs' => $js_css));

});

$app->get('/admin/page', $authenticate($app), function() use($app, $func, $js_css) {
    $list = Post::find_by_sql("SELECT id, route, title, date FROM post");  
    $app->render('admin/list.php', array('arr' => $list , 'func' => $func, 'jsCSSLibs' => $js_css));
});

$app->get('/admin/page/:id', $authenticate($app), function ($id) use($app, $js_css) {
    $post = Post::find((int)$id);   
    
    $app->render('admin/page.php', array('post' => $post, 'jsCSSLibs' => $js_css));
});

$app->post('/admin/page/:id', $authenticate($app), function ($id) use($app, $js_css) {
    $message = "Страница успешно изменена";
    $post = Post::find((int)$id);
    $post->post = $_POST['editor1'];
    $post->title = $_POST['title'];
    $post->save();
    $app->render('admin/page.php', array('post' => $post, 'message' => $message, 'jsCSSLibs' => $js_css));
    
});

$app->post('/admin/delete/', $authenticate($app), function () {
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

$app->get('/admin/news/add', $authenticate($app), function () use($app, $js_css) {
 
        Temp::delete_all(array('conditions' => array('type' => 'news')));
        $app->render('admin/news_add.php', array('jsCSSLibs' => $js_css));
});


$app->post('/admin/news/add', $authenticate($app), function () use ($app, $temp2bind){
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

$app->get('/admin/news/:id', $authenticate($app), function ($id) use($app, $selectAllImg, $js_css) {
    $news = News::find((int)$id);  
    $img = Bind::find_all_by_news_id((int)$id, array('order' => 'position'));
    $gallery = $selectAllImg();
    $app->render('admin/news_edit.php', array('news' => $news, 'images' => $img, 'gallery' => $gallery, 
                                              'id' => $news->id, 'jsCSSLibs' => $js_css));
});

$app->post('/admin/news/:id', $authenticate($app), function ($id) use($app, $selectAllImg, $js_css) {
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

$app->get('/admin/settings/:succes', $authenticate($app), function($succes) use($app, $selectAllImg, $js_css) {
    
    
    $message = $succes === 'pass' ? 'Парль успешно изменён!' : '';
        
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
    
    $app->render('admin/settings.php', array('gallery' => $gallery, 'file_name' => $wi, 'jsCSSLibs' => $js_css, 'message' => $message ));
});

$app->get('/admin/gallery', $authenticate($app), function() use($app, $js_css) {
    
    $app->render('admin/gallery.php', array('jsCSSLibs' => $js_css));
});

$app->get('/admin/upload', function() use($app, $js_css) {

    $app->render('admin/images.php', array('jsCSSLibs' => $js_css));
});


$app->post('/admin/position/', $authenticate($app), function() use($addImgThumbnail) {
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

$app->post('/admin/bind', $authenticate($app), function(){
    $bind = new Bind();
    $bind->file_id = (int)$_POST['file_id'];
    $bind->file_name = $_POST['file_name'];
    $bind->setTableId($_POST['type'], $_POST['id']);
    $bind->save();
    die($_POST['id']);
    
});

$app->post('/admin/removeimg', $authenticate($app), function(){
    $id =  $_POST['file_id'];
    $bind = Bind::find_by_file_id((int)$id);
    if($bind) $bind->delete();
    echo $id;
    
});

$app->get('/admin/thumbnail/news/:id', $authenticate($app), function($id) use($app, $addImgThumbnail, $js_css) {
	
	$thumb = $addImgThumbnail('news', $id);

    $app->render('admin/thumbnail.php', array('news' => $thumb, 'return' => '/news/' . $id, 'jsCSSLibs' => $js_css));      
});

$app->get('/admin/thumbnail/work/:id', $authenticate($app), function($id) use($app, $addImgThumbnail, $js_css) {
    
    $thumb = $addImgThumbnail('work', $id);
    
    $app->render('admin/thumbnail.php', array('news' => $thumb, 'return' => '/work/' . $id . '/edit', 
                                              'jsCSSLibs' => $js_css));      
});

$app->post('/admin/thumbnail/:id', $authenticate($app), function($id) {
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

$app->post('/admin/watermark/:id', $authenticate($app), function($id) use($watermark){
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

$app->post('/admin/setwatermark/', $authenticate($app), function(){
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

$app->get('/admin/getwatername', $authenticate($app), function(){
    try{
        $name = Files::find((int)$_GET['id']);
    }
    catch (Exception $e){
        die();
    }
    die($name->url);
});

$app->get('/admin/work/', $authenticate($app), function() use($app, $js_css) {
    $list = Work::find_by_sql('SELECT work.id, title, city FROM work INNER JOIN institution ON work.institution = institution.id');
	$app->render('admin/work.php', array('list' => $list, 'jsCSSLibs' => $js_css));

});

$app->get('/admin/institution/', $authenticate($app), function() use($app, $js_css) {
    $inst = Institution::find('all');
    $count = Institution::num_rows();
    $city = Institution::get_unique_cityes();  

    $app->render('admin/institution.php', array('inst' => $inst ,'city' => $city, 'count' => $count, 'jsCSSLibs' => $js_css));

});

$app->post('/admin/institution/', $authenticate($app), function() use($app) {

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

$app->get('/admin/institution/success/', $authenticate($app), function() use($app, $js_css) {
    $count = Institution::num_rows();
    $inst = Institution::find('all');
    $city = Institution::get_unique_cityes();
    $app->render('admin/institution.php', array('inst' => $inst, 'city' => $city, 'message' => "Учебное заведение успешно добавлено!", 'count' => $count, 'jsCSSLibs' => $js_css));

});

$app->get('/admin/work/add', $authenticate($app), function() use($app, $js_css){
    Temp::delete_all(array('conditions' => array('type' => 'work')));
    
    $school = Institution::find('all', array('select' => 'DISTINCT city', 'conditions' => array('type' => 'Школа')));
    $app->render("admin/work_add.php", array('school' => $school, 'jsCSSLibs' => $js_css));
});

$app->post('/admin/smartform/', $authenticate($app), function(){
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

$app->post('/admin/work/add', $authenticate($app), function() use($app, $temp2bind){
    
    $work = new Work();
    if(isset($_POST['institution']) && (int)$_POST['institution'] > 0) $work->institution = (int)$_POST['institution'];
    else $app->redirect('/admin/work/add');
    if(isset($_POST['work-class'])) $work->school_class = $_POST['work-class'];
    $work->year = $_POST['work-year'];
    $work->anotation = $_POST['work-desc'];
    $work->keywords = $_POST['work-keywords'];
    $work->save();

    /*связываем новость и картинки*/
    $temp2bind('work', $work->id);

    $app->redirect('/admin/thumbnail/work/'. $work->id);
    
});

$app->get('/admin/work/:id/:succes', $authenticate($app), function($id, $succes) use($app, $selectAllImg, $js_css){
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

$app->post('/admin/remove/institution', $authenticate($app), function(){
    $inst = Institution::find((int)$_POST['id']);
    Work::remove((int)$_POST['id']);
    $inst->delete();
    die('Успех!');
});

$app->post('/admin/work/:id/:edit', $authenticate($app), function($id) use($app) {
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

$app->post('/admin/temporary', $authenticate($app), function(){
    if(isset($_POST['flag']) && $_POST['flag']){
        $temp = new Temp();
        $temp->file_name = $_POST['file_name'];
        $temp->file_id = $_POST['file_id'];
        $temp->type = $_POST['type'];
        $temp->save();
    } else {
        $temp = Temp::find_by_file_id($_POST['file_id'], array('conditions' => array('type' => $_POST['type'])));
        $temp->delete();
    }
});

$app->post('/admin/change', $authenticate($app), function() use ($app){
    $user = $app->view()->getData('user');
    $pass = $app->request()->post('new-pass');    
           
    if($pass) User::change_password($user, $pass);
    
    $app->redirect('/admin/settings/pass');
});

$app->get('/admin/review', $authenticate($app), function() use($app, $js_css) {
    $join = 'INNER JOIN institution ON(review.institution = institution.id)';
    
    $re = Review::find('all', array('select' => 'review.id, review.author, review.status, institution.title, institution.type', 
                                    'conditions' => array('type' => 'r'), 'joins' => $join));
    
    $qu = Review::find('all', array('select' => 'review.id, review.author, review.status, institution.title, institution.type', 
                                    'conditions' => array('type' => 'q'), 'joins' => $join));
            
    $app->render('admin/review.php', array('jsCSSLibs' => $js_css, 're' => $re, 'qu' => $qu));
});

$app->get('/admin/review/:id', $authenticate($app), function($id) use($app, $js_css) {
    $join = 'INNER JOIN institution ON(review.institution = institution.id)';
    
    try{
        $re = Review::find($id, array('select' => 'review.id, author, email, phone, message, review.type, review.status, institution.title', 
                                      'joins' => $join));
    } catch(Exception $e){
        $app->redirect('/admin/review');
    }
    
    $user_id = User::get_user_id($app->view()->getData('user'));    
    $answer = Answer::answer_by_id($user_id, $id);
    
    $inst = Institution::find('all');
      
    $success = $app->getCookie('success') ? $app->getCookie('success') : '';
    
    $app->deleteCookie('success');
    
        
    $app->render('admin/review_edit.php', array('jsCSSLibs' => $js_css, 're' => $re, 'inst' => $inst, 'suck' => $success, 'answ' => $answer));
});

$app->post('/admin/review/:id', $authenticate($app), function($id) use($app){
    
    try{
        $re = Review::find($id);
    }catch(Exception $e){
        $app->redirect('/admin/review');
    }   
    
    if($app->request()->post('public')){
        $re->status = 1;
        $re->save();
        
    } elseif($app->request()->post('save')){
        $re->author = $app->request()->post('author');
        $re->email = $app->request()->post('email');
        $re->phone = $app->request()->post('phone');
        $re->institution = $app->request()->post('institution');
        $re->message = $app->request()->post('editor1');
        $re->save();
        $app->setCookie('success', 'Отзыв успешно изменён!');
        
    } elseif($app->request()->post('disable')){
        $re->delete();
        
        $answer = Answer::find_all_by_review_id($id);
        foreach($answer as $value){
            $value->delete();
        }
        
        $app->redirect('/admin/review');
        
    } elseif($app->request()->post('answer')){
        
        $user_id = User::get_user_id($app->view()->getData('user'));
        
        $answer = new Answer();
        $answer->answer = $app->request()->post('answer_text');
        $answer->user_id = $user_id;
        $answer->review_id = $id;
        $answer->save();
        $app->setCookie('success', 'Ответ успешно сохранён!');
    }
    
    $app->redirect('/admin/review/' . $id);
});

$app->get('/admin/removeanswer/:rid/:aid', $authenticate($app), function($rid, $aid) use($app) {
    try{
        $a = Answer::find($aid);
        $a->delete();
    }catch(Exception $e){
        $app->redirect('/admin/review/');
    }

    
    $app->redirect('/admin/review/' . $rid);
    
});
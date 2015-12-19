<?php

function routes($route, $app, $js_css) {
    $url_path = parse_url($route, PHP_URL_PATH);
    $uri_parts = explode('/', trim($url_path, ' /'));
    if(count($uri_parts) === 1) {
        $post = Post::find_by_route(array('route' => $uri_parts[0]));

        if(!$post){ echo "База данных пуста"; }
        else { 
            $app->render('template.php', array('desc' => $post->description, 'post' => $post->post, 
                                               'title' => $post->title, 'jsCSSLibs' => $js_css));
        }
    }
    elseif(count($uri_parts) === 2) {
        $parent = Post::find_by_route(array('route' => $uri_parts[0]));
        $child = Post::find_by_route(array('route' => $url_path));
        if(!$parent || !$child){ echo "База данных пуста"; }
        else { 
            $app->render('template.php', array('desc' => $parent->description, 'post' => $child->post, 
                                               'title' => $child->title, 'jsCSSLibs' => $js_css));
        }
    }
    else {echo "ЧТо-то пошло не так"; }
}

$nameUrl = function(){
    $fName = [];
    $url = Files::find('all', array('select' => 'url, name'));    
    foreach($url as $value){
        $fName[$value->name] = ( !is_null($value->url) ) ? $value->url : $value->name;
    }
    return $fName;
};


$getAltDescByName = function($name){
    $url = Files::find_by_name($name, array('select' => 'title, description'));
    if($url) return $url;
    else return [];
};

$app->get('/', function() use($app, $js_css) {	
    $app->render('home.php', array('jsCSSLibs' => $js_css)); 
});

$app->get('/kids/', function() use($app, $js_css) { routes('kids', $app, $js_css); });

$app->get('/about/', function() use($app, $js_css) { routes('about', $app, $js_css); });

$app->get('/prom/', function() use($app, $js_css) { routes('prom', $app, $js_css); });

$app->get('/video/', function() use($app, $js_css) { routes('video', $app, $js_css); });

$app->get('/school/', function() use($app, $js_css) { routes('school', $app, $js_css); });

$app->get('/student/', function() use($app, $js_css) { routes('student', $app, $js_css); });

$app->get('/minibook/', function() use($app, $js_css) { routes('minibook', $app, $js_css); });

$app->get('/kids/info/', function() use($app, $js_css) { routes('kids/info', $app, $js_css); });

$app->get('/school/info/', function() use($app, $js_css) { routes('school/info', $app, $js_css); });

$app->get('/student/info/', function() use($app, $js_css) { routes('student/info', $app, $js_css); });

$app->get('/minibook/info/', function() use($app, $js_css) { routes('minibook/info', $app, $js_css); });

$app->get('/kids/faq/', function() use($app, $js_css) { routes('kids/faq', $app, $js_css); });

$app->get('/minibook/faq/', function() use($app, $js_css) { routes('minibook/faq', $app, $js_css); });

$app->get('/school/faq/', function() use($app, $js_css) { routes('school/faq', $app, $js_css); });

$app->get('/student/faq/', function() use($app, $js_css) { routes('student/faq', $app, $js_css); });

$app->get('/kids/price/', function() use($app, $js_css) { routes('kids/price', $app, $js_css); });

$app->get('/school/price/', function() use($app, $js_css) { routes('school/price', $app, $js_css); });

$app->get('/student/price/', function() use($app, $js_css) { routes('student/price', $app, $js_css); });

$app->get('/minibook/price/', function() use($app, $js_css) { routes('minibook/price', $app, $js_css); });

$app->get('/contacts/', function() use($app, $js_css) { routes('contacts', $app, $js_css); });

$app->get('/contacts/vacancies/', function() use($app, $js_css) { routes('contacts/vacancies', $app, $js_css); });


$app->get('/news/', function() use($app, $js_css) {
    #$news = Bind::find_by_sql('SELECT file_name, title, anotation, news.id FROM bind inner join news on bind.news_id = news.id WHERE position IN ( SELECT MIN(position) as position FROM bind)');
    $news = News::find('all', array('select' => 'mini, thumbnail, id, anotation, title'));
    $app->render('news_list.php', array('news' => $news, 'title' => 'Новости', 'jsCSSLibs' => $js_css));

});

$app->get('/news/:id', function($id) use($app, $nameUrl, $getAltDescByName, $js_css){
    
    try {
        $news = News::find((int)$id);
    }catch(Exception $e){
        $app->render('404.php', array('post' => '<h1>Ошибка 404!</h1> Страница не найдена', 'jsCSSLibs' => $js_css, 
                                           'title' => 'Ошибка 404'));
        die();
    }
    
    $img = Bind::find_all_by_news_id((int)$id, array('order' => 'position'));
    
    $fName = $nameUrl();
    
    $img_arr = []; $i = 0; $altDesc = [];
    
    foreach ($img as $value){
        $arr = explode('.', $value->file_name);
        array_pop($arr);
        $water = implode('.', $arr);
        $file_water_path = FILES_PATH . '/.water/' . $water . '.jpg';
        $img_arr[$i] = is_file($file_water_path) ? '/.water/' . $water . '.jpg' : $fName[$value->file_name];
        
        $altDesc[$i] = $getAltDescByName($value->file_name);
        
        $i++;
    }
        
    $app->render('news_open.php', array('news' => $news, 'img' => $img_arr, 'id' => $id, 'title' => 'Новости',
                                        'type' => 'news', 'altDesc' => $altDesc, 'jsCSSLibs' => $js_css));
} );


$app->get('/portfolio/', function() use($app, $js_css){
    $app->render('portfolio.php', array('title' => "Портфолио", 'jsCSSLibs' => $js_css));
});

$app->post('/geography/', function(){
    $city = $_POST['city'];
    $list = Work::find_by_sql("SELECT work.id, title, city, street FROM work
                                INNER JOIN institution ON work.institution = institution.id WHERE city = '$city'");
    
    $arr = []; $i = 0;
    foreach($list as $value){
        $obj = new stdClass();
        $obj->address = $value->city . ', ' . $value->street;
        $obj->hint = $value->title;
        $obj->id = $value->id;
        $arr[$i++] = $obj;
    }
    die(json_encode($arr));
});

$app->get('/ourworks/', function() use($app, $js_css){
    $work = Work::find_by_sql("SELECT work.id, mini, thumbnail, anotation, title FROM work 
                                INNER JOIN institution ON work.institution = institution.id");
    
    $app->render('news_list.php', array('news' => $work, 'title' => 'Наши работы', 'jsCSSLibs' => $js_css));
    
});

$app->get('/ourworks/:id', function($id) use($app, $nameUrl, $getAltDescByName, $js_css){

    try{
        $work = Work::find_by_sql("SELECT work.id, anotation, title FROM work 
                                   INNER JOIN institution ON work.institution = institution.id WHERE work.id = $id");
    }catch(Exception $e){
        $app->render('404.php', array('post' => '<h1>Ошибка 404!</h1> Страница не найдена', 'jsCSSLibs' => $js_css, 
                                           'title' => 'Ошибка 404'));
        die();
    }
    
    $fName = $nameUrl();
    
    $work = $work[0];
    $img = Bind::find_all_by_work_id((int)$id, array('order' => 'position'));
    
    $img_arr = []; $i = 0; $altDesc = [];
    
    foreach ($img as $value){
        $arr = explode('.', $value->file_name);
        array_pop($arr);
        $water = implode('.', $arr);
        $file_water_path = FILES_PATH . '/.water/' . $water . '.jpg';
        $img_arr[$i] = is_file($file_water_path) ? '/.water/' . $water . '.jpg' : $fName[$value->file_name];
        
        $altDesc[$i] = $getAltDescByName($value->file_name);
        
        $i++;
    }
    $app->render('news_open.php', array('news' => $work, 'img' => $img_arr, 'id' => $id, 'title' => 'Наши работы',
                                        'type' => 'work', 'altDesc' => $altDesc, 'jsCSSLibs' => $js_css));
} );


$app->notFound(function () use ($app, $js_css) {
    $app->render('404.php', array('post' => '<h1>Ошибка 404!</h1> Страница не найдена', 'jsCSSLibs' => $js_css, 
                                       'title' => 'Ошибка 404'));
});

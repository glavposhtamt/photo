<?php

function routes($route, $app) {
    $url_path = parse_url($route, PHP_URL_PATH);
    $uri_parts = explode('/', trim($url_path, ' /'));
    if(count($uri_parts) === 1) {
        $post = Post::find_by_route(array('route' => $uri_parts[0]));

        if(!$post){ echo "База данных пуста"; }
        else { 
            $app->render('template.php', array('desc' => $post->description, 'post' => $post->post, 'title' => $post->title));
        }
    }
    elseif(count($uri_parts) === 2) {
        $parent = Post::find_by_route(array('route' => $uri_parts[0]));
        $child = Post::find_by_route(array('route' => $url_path));
        if(!$parent || !$child){ echo "База данных пуста"; }
        else { 
            $app->render('template.php', array('desc' => $parent->description, 'post' => $child->post, 'title' => $child->title));
        }
    }
    else {echo "ЧТо-то пошло не так"; }
}

function child_routes($route_parent, $route_child, $app){  

    $parent = Post::find_by_route(array('route' => $route_parent));
    $child = Post::find_by_route(array('route' => $route_child));
    if(!$parent || !$child){ echo "База данных пуста"; }
    else { 
        $app->render('template.php', array('desc' => $parent->description, 'post' => $child->post, 'title' => $child->title));
    }
}

$app->get('/', function() use($app) {	$app->render('index.php'); });

$app->get('/kids/', function() use($app) { routes('kids', $app); });

$app->get('/about/', function() use($app) { routes('about', $app); });

$app->get('/prom/', function() use($app) { routes('prom', $app); });

$app->get('/video/', function() use($app) { routes('video', $app); });

$app->get('/school/', function() use($app) { routes('school', $app); });

$app->get('/student/', function() use($app) { routes('student', $app); });

$app->get('/minibook/', function() use($app) { routes('minibook', $app); });

$app->get('/kids/info/', function() use($app) { routes('kids/info', $app); });

$app->get('/school/info/', function() use($app) { routes('school/info', $app); });

$app->get('/student/info/', function() use($app) { routes('student/info', $app); });

$app->get('/minibook/info/', function() use($app) { routes('minibook/info', $app); });

$app->get('/kids/faq/', function() use($app) { child_routes('kids', 'faq', $app); });

$app->get('/minibook/faq/', function() use($app) { child_routes('minibook', 'faq', $app); });

$app->get('/school/faq/', function() use($app) { child_routes('school', 'faq', $app); });

$app->get('/student/faq/', function() use($app) { child_routes('student', 'faq', $app); });

$app->get('/kids/price/', function() use($app) { routes('kids/price', $app); });

$app->get('/school/price/', function() use($app) { routes('school/price', $app); });

$app->get('/student/price/', function() use($app) { routes('student/price', $app); });

$app->get('/minibook/price/', function() use($app) { routes('minibook/price', $app); });

$app->get('/contacts/', function() use($app) { routes('contacts', $app); });

$app->get('/contacts/vacancies/', function() use($app) { routes('contacts/vacancies', $app); });


$app->get('/news/', function() use($app) {
    #$news = Bind::find_by_sql('SELECT file_name, title, anotation, news.id FROM bind inner join news on bind.news_id = news.id WHERE position IN ( SELECT MIN(position) as position FROM bind)');
    $news = News::find('all', array('select' => 'mini, thumbnail, id, anotation, title'));
    $app->render('news_list.php', array('news' => $news));

});

$app->get('/news/:id', function($id) use($app){
    $news = News::find((int)$id);
    $img = Bind::find_all_by_news_id((int)$id, array('order' => 'position'));
    $img_arr = []; $i = 0;
    foreach ($img as $value){
        $arr = explode('.', $value->file_name);
        array_pop($arr);
        $water = implode('.', $arr);
        $file_water_path = FILES_PATH . '/water/' . $water . '.jpg';
        $img_arr[$i] = is_file($file_water_path) ? '/water/' . $water . '.jpg' : $value->file_name;
        $i++;
    }
    $app->render('news_open.php', array('news' => $news, 'img' => $img_arr, 'id' => $id));
} );



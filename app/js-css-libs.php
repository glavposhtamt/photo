<?php 

$bower_components = '/bower_components/';
$js = '/js/';
$css = '/css/';

$jsCSSLibs = array(
    'jQuery' => array(
        'js' => $bower_components . 'jquery/dist/jquery.min.js'
    ),
    'default-template' => array(
        'css' => [$css . 'kernel_main.css', $css . 'template.css']        
    ),
    
    'ymaps' => array(
        'js' => ['//api-maps.yandex.ru/2.1/?lang=ru_RU', $js . 'ymaps.js']
    ),
    
    'ckeditor' => array(
        'js' => $bower_components . 'ckeditor/ckeditor.js'
    ),
    
    'jquery.cookie' => array(
        'js' => $bower_components . 'jquery.cookie/jquery.cookie.js'
    ),
    
    'moment' => array(
        'js' => [$bower_components . 'moment/min/moment.min.js', 'moment/locale/ru.js']
    ),
    
    'bootstrap' => array(
        'js' => $bower_components . 'bootstrap/dist/js/bootstrap.min.js',
        'css' => $bower_components . 'bootstrap/dist/css/bootstrap.min.css'
    ),
    
    'datetimepicker' => array(
        'js' => $bower_components . 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        'css' => $bower_components . 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'
    ),
    
    'crop' => array(
        'js' => [$js . 'jquery.Jcrop.min.js', $js . 'crop.js'],
        'css' => $css . 'jquery.Jcrop.css'
    ),
    
    'admin' => array(
        'js' => $js . 'admin.js',
        'css' => $css . 'simple-sidebar.css'
    ),
    
    'sortable' => array(
        'js' => $js . 'sortable.js'
    ),
    
    'contextMenu' => array(
        'css' => $bower_components . 'jQuery-contextMenu/dist/jquery.contextMenu.min.css',
        'js' => [ $js . 'jquery-1.11.0.min.js', $bower_components . 'jQuery-contextMenu/src/jquery.contextMenu.js', ]
    ),
    
    'fontawesome' => array(
        'css' => $bower_components . 'fontawesome/css/font-awesome.min.css'
    ),
    
    'blueimp-gallery' => array(
        'css' => $css . 'blueimp-gallery.min.css',
        'js' => $js . 'jquery.blueimp-gallery.min.js'
    ),
    
    'folders' => array(
        'js' => $js . 'folders.js'
    ),
    
);
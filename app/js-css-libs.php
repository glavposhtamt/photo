<?php 

$bower_components = '/bower_components/';
$vendorJS = '/js/vendor/';
$vendorCSS = '/css/vendor/';
$js = '/js/';
$css = '/css/';
$libTest = '/testing/lib/';
$specTest = '/testing/spec/';

$jsCSSLibs = array(
    'jQuery' => array(
        'js' => $bower_components . 'jquery/dist/jquery.min.js'
    ),
    
    'default-template' => array(
        'css' => [$css . 'kernel_main.css', $css . 'template.css', $css . 'styles.css', $css . 'css.css', $css . 'objects.css']        
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
        'js' => [$bower_components . 'moment/min/moment.min.js', $bower_components . 'moment/locale/ru.js']
    ),
    
    'bootstrap' => array(
        'js' => $bower_components . 'bootstrap/dist/js/bootstrap.js',
        'css' => $bower_components . 'bootstrap/dist/css/bootstrap.min.css'
    ),
    
    'datetimepicker' => array(
        'js' => $bower_components . 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        'css' => $bower_components . 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'
    ),
    
    'crop' => array(
        'js' => [$vendorJS . 'jquery.Jcrop.min.js', $js . 'crop.js'],
        'css' => $vendorCSS . 'jquery.Jcrop.css'
    ),
    
    'login' => array(
        'css' => $css . 'login.css'
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
        'js' => [ $vendorJS . 'jquery-1.11.0.min.js', $bower_components . 'jQuery-contextMenu/src/jquery.contextMenu.js', ]
    ),
        
    'gallery-scripts' => array(
        'js' => $js . 'gallery-scripts.js'
    ),
    
    'render-function-fm' => array(
        'js' => $js . 'render-function-fm.js',
        'css' => $css . 'render-function-fm.css'
    ),
    
    'fontawesome' => array(
        'css' => $bower_components . 'fontawesome/css/font-awesome.min.css'
    ),
    
    'blueimp-gallery' => array(
        'css' => $vendorCSS . 'blueimp-gallery.min.css',
        'js' => $vendorJS . 'jquery.blueimp-gallery.min.js'
    ),
    
    'folders' => array(
        'css' => $css . 'folders.css',
        'js' => $js . 'folders.js'
    ),
    
    'fileupload' => array(
        'css' => $vendorCSS . 'jquery.fileupload.css',
        'js' => [$vendorJS . 'jquery.ui.widget.js', $vendorJS . 'load-image.all.min.js', $vendorJS . 'jquery.fileupload.js',
                 $vendorJS . 'jquery.fileupload-process.js', $vendorJS . 'jquery.fileupload-image.js', 
                 $vendorJS . 'jquery.fileupload-validate.js']
    ),
    
    'fileupload-ui' => array(
        'css' => $vendorCSS . 'jquery.fileupload-ui.css',
        'js' => $vendorJS . 'jquery.fileupload-ui.js'
    ),
    
    'tmpl' => array(
        'js' => $vendorJS . 'tmpl.min.js',
    ),
    
    'minimalUploadWidget' => array(
        'js' => $vendorJS . 'minimalUploadWidget.js'
    ),

    'mainUpload' => array(
        'js' => $vendorJS . 'main.js'
    ),
    
    'jcarousellite' => array(
        'js' => $vendorJS . 'jcarousellite.js'
    ),
    
    'slider' => array(
        'js' => $js . 'slider.js',
        'css' => $css . 'slider.css'
    ),
    
    'vk-share' => array(
        'js' => 'http://vk.com/js/api/share.js?90'
    ),
    
    'vk-api' => array(
        'js' => '//vk.com/js/api/openapi.js'
    ),
    
    /* Подключение тестовой библиотеки */
    
    'jasmine' => array(
        'js' => [$libTest . 'jasmine-2.3.4/jasmine.js', $libTest . 'jasmine-2.3.4/jasmine-html.js',
                 $libTest . 'jasmine-2.3.4/boot.js'],
        'css' => $libTest . 'jasmine-2.3.4/jasmine.css'
    ),
    
    /* Подключение тестов */    
    
    'spec-context-menu' => array(
        'js' => $specTest . 'gallerySpec.js'
    )
);
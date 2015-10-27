<?php

require '../Slim//vendor/autoload.php';     //include the framework in the project

$projectDir = __DIR__ . "/app";   //define the directory containing the project files

require "$projectDir/includes.php";     //include the file which contains all the project related includes

ActiveRecord\Config::initialize(function($cfg) use( $projectDir, $config_db ) {
    $cfg->set_model_directory("$projectDir/Models");
    $cfg->set_connections($config_db);
});

$app = new \Slim\Slim(array(
    'templates.path' => "$projectDir/Views",
    'config_db' => $connection,
    'upload_options' => $options
));      //instantiate a new Framework Object and define the path to the folder that holds the views for this project

require "$projectDir/routes.php";       //include the file which contains all the routes/route inclusions


$app->run();                          //load the application

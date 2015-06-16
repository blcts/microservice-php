<?php
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

$app->get('/hello/{name}', function($name) use($app) {    
    return "Hello $name!\n";
});

$data = '{"service": {
	"name": "Example Service in PHP",
	"description": "This is a sample scaffolding for creating a PHP microservice",
	"language": "PHP",
	"dependencies": [
	{"silex": "The PHP micro-framework based on the Symfony2 Components"},
	{"composer": "Composer is a tool for dependency management in PHP."}	
	]
	},
	"links":{
	"self":"/info"
}}';


$app->get('/info', function () use ($data) { 
	$json_string = json_encode($data, JSON_PRETTY_PRINT);	
    return $json_string; 
});

$app->run();

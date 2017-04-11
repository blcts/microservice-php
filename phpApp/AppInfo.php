<?php
namespace phpApp;

class AppInfo
{
    public function getInfo()
    {
		$info = '{"service": {
			"version": "3.2",
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

        return $info;
    }
}
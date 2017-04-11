<?php

namespace phpApp\Test;
require_once 'phpApp/AppInfo.php';
use phpApp\AppInfo;

class AppInfoTest extends \PHPUnit_Framework_TestCase
{
    public function testPhpAppInfoResponse()
    {
		$expectedInfo = '{"service": {
			"author": "Blcts",			
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

        $info = new AppInfo();
        $currentInfo = $info->getInfo();
	
        $this->assertEquals($expectedInfo, $currentInfo);	
    }
}
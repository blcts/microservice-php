<?php
$loader = require __DIR__.'/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$app = new Silex\Application();

$app->get('/hello/{name}', function($name) use($app) {    
    return "Hello $name!\n";
});

class AppInfo
{
    public function getInfo()
    {
		$info = array(
			   'service' => array(
					'author' => 'Blcts',
					'name' => 'Example Service in PHP',
					'description' => 'This is a sample scaffolding for creating a PHP microservice',
					'language' => 'PHP',
					'version' => '5.3',
					'dependencies' => 
					array(
						'silex' => 'The PHP micro-framework based on the Symfony2 Components',
						'composer' => 'Composer is a tool for dependency management in PHP.',
					),
				),
			   'links' => array(
					'self' => '/info',
				)
			);

        return $info;
    }
}		
	
$app->get('/info', function () use ($app) {
	$info = new AppInfo();
	$data = $info->getInfo();
	
	return $app->json($data); 
});


$app->get('/send', function() {    
	$connection = new AMQPConnection('192.168.59.103', 5672, 'guest', 'guest');
	$channel = $connection->channel();


	$channel->queue_declare('hello', false, false, false, false);

	$msg = new AMQPMessage('Hello World!');
	$channel->basic_publish($msg, '', 'hello');

	$notify = " [x] Sent 'Hello World!'\n";

	$channel->close();
	$connection->close(); 
	
	return $notify;
});



$app->get('/receive', function() {    
	$connection = new AMQPConnection('192.168.59.103', 5672, 'guest', 'guest');
	$channel = $connection->channel();


	$channel->queue_declare('hello', false, false, false, false);

	echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

	$callback = function($msg) {
	  echo " [x] Received ", $msg->body, "\n";
	};

	$channel->basic_consume('hello', '', false, true, false, false, $callback);

	try {
		while(count($channel->callbacks)) {
			$channel->wait();
		}
	} catch (Exception $e]) {
		//Mute exception
	}

	$channel->close();
	$connection->close();    	
});

$app->run();


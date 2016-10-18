<?php
	
	require_once __DIR__.'/../vendor/autoload.php';
	
	use Symfony\Component\Debug\ErrorHandler;
	use Symfony\Component\Debug\ExceptionHandler;
	
	$app = new Silex\Application();
	
	ErrorHandler::register();
	ExceptionHandler::register();
	
	$app->register(new Silex\Provider\RoutingServiceProvider());
	
	require_once __DIR__.'/../app/routes.php';
	
	$app->run();
	
?>

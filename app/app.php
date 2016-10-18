<?php
	
	use Symfony\Component\Debug\ErrorHandler;
	use Symfony\Component\Debug\ExceptionHandler;
	
	ErrorHandler::register();
	ExceptionHandler::register();
	
	$app->register(new Silex\Provider\RoutingServiceProvider());
	
?>

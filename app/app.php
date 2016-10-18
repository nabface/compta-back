<?php
	
	use Symfony\Component\Debug\ErrorHandler;
	use Symfony\Component\Debug\ExceptionHandler;
	
	// register global error and exception handlers
	ErrorHandler::register();
	ExceptionHandler::register();
	
	// register service providers
	$app->register(new Silex\Provider\DoctrineServiceProvider());
	$app->register(new Silex\Provider\RoutingServiceProvider());
	
	//register services
	$app['dao.group'] = new Compta\DAO\GroupDAO($app['db']);
	$app['dao.user'] = function($app) {
		$userDAO = new Compta\DAO\UserDAO($app['db']);
		$userDAO->setGroupDAO($app['dao.group']);
		return $userDAO;
	};
	$app['dao.depense'] = function($app) {
		$depenseDAO = new Compta\DAO\DepenseDAO($app['db']);
		$depenseDAO->setGroupDAO($app['dao.group']);
		$depenseDAO->setUserDAO($app['dao.user']);
		return $depenseDAO;
	};
	
?>

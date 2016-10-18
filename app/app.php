<?php
	
	use Symfony\Component\Debug\ErrorHandler;
	use Symfony\Component\Debug\ExceptionHandler;
	use Symfony\Component\HttpFoundation\Request;
	
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
	
	// register JSON data decoder for JSON requests
	$app->before(function (Request $request) {
		if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
			$data = json_decode($request->getContent(), true);
			$request->request->replace(is_array($data) ? $data : array());
		}
	});
	
?>

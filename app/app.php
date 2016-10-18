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
	$app['dao.user'] = new Compta\DAO\UserDAO($app['db']);
	$app['dao.user'] = $app['dao.user']->setGroupDAO($app['dao.group']);
	$app['dao.depense'] = new Compta\DAO\DepenseDAO($app['db']);
	$app['dao.depense'] = $app['dao.depense']->setGroupDAO($app['dao.group']);
	
	// register JSON data decoder for JSON requests
	$app->before(function (Request $request) {
		if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
			$data = json_decode($request->getContent(), true);
			$request->request->replace(is_array($data) ? $data : array());
		}
	});
	
?>

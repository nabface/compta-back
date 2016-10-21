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
	$app->register(new Silex\Provider\SessionServiceProvider());
	$app->register(new Silex\Provider\MonologServiceProvider(), array(
		'monolog.logfile' => __DIR__.'/../logs/dev.log',
		'monolog.name' => 'Compta',
		'monolog.level' => $app['monolog.level']
	));
	
	//register services
	$app['dao.group'] = new Compta\DAO\GroupDAO($app['db']);
	$app['dao.user'] = new Compta\DAO\UserDAO($app['db']);
	$app['dao.depense'] = new Compta\DAO\DepenseDAO($app['db']);
	$app['dao.user']->setDepenseDAO($app['dao.depense']);
	
	// register JSON data decoder for JSON requests
	$app->before(function (Request $request) {
		if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
			$data = json_decode($request->getContent(), true);
			$request->request->replace(is_array($data) ? $data : array());
		}
	});
	
?>

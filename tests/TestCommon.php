<?php
	
	namespace Compta\Tests;
	
	trait TestCommon {
		
		public function createApplication() {
			$app = new \Silex\Application();
			require __DIR__.'/../app/config/dev.php';
			require __DIR__.'/../app/app.php';
			require __DIR__.'/../app/routes.php';
			$app['debug'] = true;
			unset($app['exception_handler']);
			return $app;
		}
		
	}
	
?>

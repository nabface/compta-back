<?php
	
	use Silex\WebTestCase;
	
	class APIControllerReadTest extends WebTestCase {
		
		public function createApplication() {
			$app = new Silex\Application();
			require __DIR__.'/../../app/config/dev.php';
			require __DIR__.'/../../app/app.php';
			require __DIR__.'/../../app/routes.php';
			$app['debug'] = true;
			unset($app['exception_handler']);
			return $app;
		}
		
		public function testGetGroups() {
			$client = $this->createClient();
			$crawler = $client->request('GET', '/groups');
			$this->assertTrue($client->getResponse()->isOk());
		}
		
		public function testGetUsers() {
			$client = $this->createClient();
			$crawler = $client->request('GET', '/group/1/users');
			$this->assertTrue($client->getResponse()->isOk());
		}
		
		public function testGetDepenses() {
			$client = $this->createClient();
			$crawler = $client->request('GET', '/group/1/depenses');
			$this->assertTrue($client->getResponse()->isOk());
		}
		
	}
	
?>

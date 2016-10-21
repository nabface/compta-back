<?php
	
	use Silex\WebTestCase;
	
	class APIControllerCreateTest extends WebTestCase {
		
		public function createApplication() {
			$app = new Silex\Application();
			require __DIR__.'/../../app/config/dev.php';
			require __DIR__.'/../../app/app.php';
			require __DIR__.'/../../app/routes.php';
			$app['debug'] = true;
			unset($app['exception_handler']);
			return $app;
		}
		
		public function testAddGroupSuccess() {
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/group',
					array(),
					array(),
					array('CONTENT_TYPE' => 'application/json'),
					'{"name":"test_group"}'
				);
			$this->assertEquals(
				201,
				$client->getResponse()->getStatusCode()
			);
			$this->assertTrue(
				$client->getResponse()->headers->contains(
					'Content-Type',
					'application/json'
				)
			);
			$this->assertContains(
				'"name":"test_group"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testAddGroupFailure() {
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/group',
					array(),
					array(),
					array('CONTENT_TYPE' => 'application/json'),
					'{"Name":"test_group"}'
				);
			$this->assertEquals(
				400,
				$client->getResponse()->getStatusCode()
			);
			$this->assertTrue(
				$client->getResponse()->headers->contains(
					'Content-Type',
					'application/json'
				)
			);
			$this->assertContains(
				'"error":"Param\u00e8tre requis manquant\u00a0: name"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testAddUserSuccess() {
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/user',
					array(),
					array(),
					array('CONTENT_TYPE' => 'application/json'),
					'{"username":"test_user","usercolor":"test_color","usergroup":"test_group"}'
				);
			$this->assertEquals(
				201,
				$client->getResponse()->getStatusCode()
			);
			$this->assertTrue(
				$client->getResponse()->headers->contains(
					'Content-Type',
					'application/json'
				)
			);
			$this->assertContains(
				'"username":"test_user"',
				$client->getResponse()->getContent()
			);
			$this->assertContains(
				'"usercolor":"test_color"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testAddUserFailure() {
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/user',
					array(),
					array(),
					array('CONTENT_TYPE' => 'application/json'),
					'{"username":"test_user","usercolor":"test_color","Usergroup":"test_group"}'
				);
			$this->assertEquals(
				400,
				$client->getResponse()->getStatusCode()
			);
			$this->assertTrue(
				$client->getResponse()->headers->contains(
					'Content-Type',
					'application/json'
				)
			);
			$this->assertContains(
				'"error":"Param\u00e8tre requis manquant\u00a0: usergroup"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testAddDepenseSuccess() {
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/depense',
					array(),
					array(),
					array('CONTENT_TYPE' => 'application/json'),
					'{"Montant":"100.00","Payeur":1,"Concernes":"2,3,4","usergroup":"test_group","Description":"test_depense"}'
				);
			$this->assertEquals(
				201,
				$client->getResponse()->getStatusCode()
			);
			$this->assertTrue(
				$client->getResponse()->headers->contains(
					'Content-Type',
					'application/json'
				)
			);
			$this->assertContains(
				'"Montant":100',
				$client->getResponse()->getContent()
			);
			$this->assertContains(
				'"Payeur":1',
				$client->getResponse()->getContent()
			);
			$this->assertContains(
				'"Concernes":"2,3,4"',
				$client->getResponse()->getContent()
			);
			$this->assertContains(
				'"nbConcernes":3',
				$client->getResponse()->getContent()
			);
			$this->assertContains(
				'"usergroup":"test_group"',
				$client->getResponse()->getContent()
			);
			$this->assertContains(
				'"Description":"test_depense"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testAddDepenseFailure() {
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/depense',
					array(),
					array(),
					array('CONTENT_TYPE' => 'application/json'),
					'{"Montant":"100.00","Payeur":1,"Concernes":"2,3,4","usergroup":"test_group","description":"test_depense"}'
				);
			$this->assertEquals(
				400,
				$client->getResponse()->getStatusCode()
			);
			$this->assertTrue(
				$client->getResponse()->headers->contains(
					'Content-Type',
					'application/json'
				)
			);
			$this->assertContains(
				'"error":"Param\u00e8tre requis manquant\u00a0: Description"',
				$client->getResponse()->getContent()
			);
		}
		
	}
	
?>

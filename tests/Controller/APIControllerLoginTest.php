<?php
	
	use Silex\WebTestCase;
	
	class APIControllerLoginTest extends WebTestCase {
		
		use Compta\Tests\TestCommon;
		
		public function testLoginFailure() {
			$client = $this->createClient();
			$crawler = $client->request(
				'POST',
				'/login',
				array(),
				array(),
				array('CONTENT_TYPE' => 'application/json'),
				'{"name":"admin","password":"nopassword"}'
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
				'"error":"Mot de passe incorrect pour l\u2019utilisateur admin"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testLoginSuccess() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
				'POST',
				'/login',
				array(),
				array(),
				array('CONTENT_TYPE' => 'application/json'),
				'{"name":"admin","password":"azerty"}'
			);
			$this->assertEquals(
				200,
				$client->getResponse()->getStatusCode()
			);
			$this->assertTrue(
				$client->getResponse()->headers->contains(
					'Content-Type',
					'application/json'
				)
			);
			$json = $client->getResponse()->getContent();
			$this->assertContains(
				'"status":"OK"',
				$json
			);
			$TESTS['apikey'] = json_decode($json, true)['key'];
		}
		
	}
	
?>

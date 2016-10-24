<?php
	
	use Silex\WebTestCase;
	
	class APIControllerLogoutTest extends WebTestCase {
		
		use Compta\Tests\TestCommon;
		
		public function testLogoutSuccess() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
				'GET',
				'/logout',
				array(),
				array(),
				array('HTTP_apikey' => $TESTS['apikey'])
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
			unset($TESTS['apikey']);
		}
		
	}
	
?>

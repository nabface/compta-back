<?php
	
	use Silex\WebTestCase;
	
	class APIControllerReadTest extends WebTestCase {
		
		use Compta\Tests\TestCommon;
		
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

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
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request('GET', '/group/'.$TESTS['group_id'].'/users');
			$this->assertTrue($client->getResponse()->isOk());
		}
		
		public function testGetDepenses() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request('GET', '/group/'.$TESTS['group_id'].'/depenses');
			$this->assertTrue($client->getResponse()->isOk());
		}
		
	}
	
?>

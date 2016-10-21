<?php
	
	use Silex\WebTestCase;
	
	class APIControllerDeleteTest extends WebTestCase {
		
		use Compta\Tests\TestCommon;
		
		public function testDeleteDepenseSuccess() {
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/depense/274'
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
			$this->assertContains(
				'"status":"OK"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteDepenseFailure() {
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/depense/274'
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
				'"error":"Pas de d\u00e9pense enregistr\u00e9e avec l\u2019id 274"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteUserSuccess() {
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/user/104'
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
			$this->assertContains(
				'"status":"OK"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteUserFailure() {
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/user/104'
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
				'"error":"Pas d\u2019utilisateur enregistr\u00e9 avec l\u2019id 104"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteGroupSuccess() {
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/group/2'
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
			$this->assertContains(
				'"status":"OK"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteGroupFailure() {
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/group/2'
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
				'"error":"Pas de groupe enregistr\u00e9 avec l\u2019id 2"',
				$client->getResponse()->getContent()
			);
		}
		
	}
	
?>

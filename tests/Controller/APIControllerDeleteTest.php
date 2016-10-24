<?php
	
	use Silex\WebTestCase;
	
	class APIControllerDeleteTest extends WebTestCase {
		
		use Compta\Tests\TestCommon;
		
		public function testDeleteDepenseUnauth() {
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/depense/1'
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
				'"error":"Le header \u0027apikey\u0027 n\u2019est pas d\u00e9fini"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteDepenseSuccess() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/depense/'.$TESTS['depense_id'],
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
			$this->assertContains(
				'"status":"OK"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteDepenseFailure() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/depense/'.$TESTS['depense_id'],
					array(),
					array(),
					array('HTTP_apikey' => $TESTS['apikey'])
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
				'"error":"Pas de d\u00e9pense enregistr\u00e9e avec l\u2019id '.$TESTS['depense_id'].'"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteUserUnauth() {
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/user/1'
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
				'"error":"Le header \u0027apikey\u0027 n\u2019est pas d\u00e9fini"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteUserSuccess() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/user/'.$TESTS['user_id'],
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
			$this->assertContains(
				'"status":"OK"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteUserFailure() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/user/'.$TESTS['user_id'],
					array(),
					array(),
					array('HTTP_apikey' => $TESTS['apikey'])
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
				'"error":"Pas d\u2019utilisateur enregistr\u00e9 avec l\u2019id '.$TESTS['user_id'].'"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteGroupUnauth() {
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/group/1'
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
				'"error":"Le header \u0027apikey\u0027 n\u2019est pas d\u00e9fini"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteGroupSuccess() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/group/'.$TESTS['group_id'],
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
			$this->assertContains(
				'"status":"OK"',
				$client->getResponse()->getContent()
			);
		}
		
		public function testDeleteGroupFailure() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'DELETE',
					'/admin/group/'.$TESTS['group_id'],
					array(),
					array(),
					array('HTTP_apikey' => $TESTS['apikey'])
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
				'"error":"Pas de groupe enregistr\u00e9 avec l\u2019id '.$TESTS['group_id'].'"',
				$client->getResponse()->getContent()
			);
		}
		
	}
	
?>

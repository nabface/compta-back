<?php
	
	use Silex\WebTestCase;
	
	class APIControllerCreateTest extends WebTestCase {
		
		use Compta\Tests\TestCommon;
		
		public function testAddGroupUnauth() {
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/group'
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
		
		public function testAddGroupFailure() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/group',
					array(),
					array(),
					array(
						'CONTENT_TYPE' => 'application/json',
						'HTTP_apikey' => $TESTS['apikey']
					),
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
		
		public function testAddGroupSuccess() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/group',
					array(),
					array(),
					array(
						'CONTENT_TYPE' => 'application/json',
						'HTTP_apikey' => $TESTS['apikey']
					),
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
			$json = $client->getResponse()->getContent();
			$this->assertContains(
				'"name":"test_group"',
				$json
			);
			$TESTS['group_id'] = json_decode($json, true)['records']['id'];
		}
		
		public function testAddUserUnauth() {
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/user'
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
		
		public function testAddUserFailure() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/user',
					array(),
					array(),
					array(
						'CONTENT_TYPE' => 'application/json',
						'HTTP_apikey' => $TESTS['apikey']
					),
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
		
		public function testAddUserSuccess() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/user',
					array(),
					array(),
					array(
						'CONTENT_TYPE' => 'application/json',
						'HTTP_apikey' => $TESTS['apikey']
					),
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
			$json = $client->getResponse()->getContent();
			$this->assertContains(
				'"username":"test_user"',
				$json
			);
			$this->assertContains(
				'"usercolor":"test_color"',
				$json
			);
			$TESTS['user_id'] = json_decode($json, true)['records']['Id'];
		}
		
		public function testAddDepenseUnauth() {
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/group'
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
		
		public function testAddDepenseFailure() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/depense',
					array(),
					array(),
					array(
						'CONTENT_TYPE' => 'application/json',
						'HTTP_apikey' => $TESTS['apikey']
					),
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
		
		public function testAddDepenseSuccess() {
			global $TESTS;
			$client = $this->createClient();
			$crawler = $client->request(
					'POST',
					'/admin/depense',
					array(),
					array(),
					array(
						'CONTENT_TYPE' => 'application/json',
						'HTTP_apikey' => $TESTS['apikey']
					),
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
			$json = $client->getResponse()->getContent();
			$this->assertContains(
				'"Montant":100',
				$json
			);
			$this->assertContains(
				'"Payeur":1',
				$json
			);
			$this->assertContains(
				'"Concernes":"2,3,4"',
				$json
			);
			$this->assertContains(
				'"nbConcernes":3',
				$json
			);
			$this->assertContains(
				'"usergroup":"test_group"',
				$json
			);
			$this->assertContains(
				'"Description":"test_depense"',
				$json
			);
			$TESTS['depense_id'] = json_decode($json, true)['records']['Id'];
		}
		
	}
	
?>

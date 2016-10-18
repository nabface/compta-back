<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	
	class APIControllerRead {
		
		public function getUsers($group_id, Application $app) {
			$users = $app['dao.user']->findByGroup($group_id);
			return $app->json(array(
				'records' => $users
			), 200);
		}
		
		public function getDepenses($group_id, Application $app) {
			$depenses = $app['dao.depense']->findByGroup($group_id);
			return $app->json(array(
				'records' => $depenses
			), 200);
		}
		
	}
	
?>

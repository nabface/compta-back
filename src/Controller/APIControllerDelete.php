<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	
	class APIControllerDelete {
		
		public function deleteGroup($id, Application $app) {
			$app['dao.depense']->deleteByGroup($id);
			$app['dao.user']->removeFromGroup($id);
			$app['dao.group']->delete($id);
			return $app->json('No Content', 204);
		}
		
		public function deleteDepense($id, Application $app) {
			$app['dao.depense']->delete($id);
			return $app->json('No Content', 204);
		}
		
		public function deleteUser($id, Application $app) {
			$app['dao.depense']->deleteByUser($id);
			$app['dao.user']->delete($id);
			return $app->json('No Content', 204);
		}
		
	}
	
?>

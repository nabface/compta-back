<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	
	class APIControllerDelete {
		
		public function deleteDepense($id, Application $app) {
			// TODO - check that user is logged in as admin
			if ($app['dao.depense']->get($id)) {
				$app['dao.depense']->delete($id);
				return $app->json(array(
					'status' => 'OK'
				), 200);
			}
			else {
				return $app->json(array(
					'status' => 'KO',
					'error' => 'Pas de dépense enregistrée avec l’id '.$id
				), 400);
			}
		}
		
		public function deleteUser($id, Application $app) {
			// TODO - check that user is logged in as admin
			if ($app['dao.user']->get($id)) {
				$app['dao.depense']->deleteByUser($id);
				$app['dao.user']->delete($id);
				return $app->json(array(
					'status' => 'OK'
				), 200);
			}
			else {
				return $app->json(array(
					'status' => 'KO',
					'error' => 'Pas d’utilisateur enregistré avec l’id '.$id
				), 400);
			}
		}
		
		public function deleteGroup($id, Application $app) {
			// TODO - check that user is logged in as admin
			if ($app['dao.group']->get($id)) {
				$app['dao.depense']->deleteByGroup($id);
				$app['dao.user']->removeFromGroup($id);
				$app['dao.group']->delete($id);
				return $app->json(array(
					'status' => 'OK'
				), 200);
			}
			else {
				return $app->json(array(
					'status' => 'KO',
					'error' => 'Pas de groupe enregistré avec l’id '.$id
				), 400);
			}
		}
		
	}
	
?>

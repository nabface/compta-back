<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	
	class APIControllerDelete {
		
		use Security;
		
		public function deleteDepense($id, Request $request, Application $app) {
			$json = $this->isLoggedIn($request, $app);
			if ($json === NULL) {
				if ($app['dao.depense']->get($id)) {
					$app['dao.depense']->delete($id);
					$json = $app->json(array(
						'status' => 'OK'
					), 200);
				}
				else {
					$json = $app->json(array(
						'status' => 'KO',
						'error' => 'Pas de dépense enregistrée avec l’id '.$id
					), 400);
				}
			}
			return $json;
		}
		
		public function deleteUser($id, Request $request, Application $app) {
			$json = $this->isLoggedIn($request, $app);
			if ($json === NULL) {
				if ($app['dao.user']->get($id)) {
					$app['dao.depense']->deleteByUser($id);
					$app['dao.user']->delete($id);
					$json = $app->json(array(
						'status' => 'OK'
					), 200);
				}
				else {
					$json = $app->json(array(
						'status' => 'KO',
						'error' => 'Pas d’utilisateur enregistré avec l’id '.$id
					), 400);
				}
			}
			return $json;
		}
		
		public function deleteGroup($id, Request $request, Application $app) {
			$json = $this->isLoggedIn($request, $app);
			if ($json === NULL) {
				if ($app['dao.group']->get($id)) {
					$app['dao.depense']->deleteByGroup($id);
					$app['dao.user']->removeFromGroup($id);
					$app['dao.group']->delete($id);
					$json = $app->json(array(
						'status' => 'OK'
					), 200);
				}
				else {
					$json = $app->json(array(
						'status' => 'KO',
						'error' => 'Pas de groupe enregistré avec l’id '.$id
					), 400);
				}
			}
			return $json;
		}
		
	}
	
?>

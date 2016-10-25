<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	
	class APIControllerRead {
		
		public function getGroups(Application $app) {
			$groups = $app['dao.group']->listAll();
			$result = [];
			foreach ($groups as $group) {
				$result[] = array(
					'id' => $group->getId(),
					'name' => $group->getName()
				);
			}
			return $app->json(array(
				'records' => $result,
				'status' => 'OK'
			), 200);
		}
		
		public function getUsers($group_id, Application $app) {
			$users = $app['dao.user']->findByGroup($group_id);
			$result = [];
			foreach ($users as $user) {
				$result[] = array(
					'Id' => $user->getId(),
					'username' => $user->getName(),
					'usergroup' => $app['dao.group']->get($group_id)->getName(),
					'usercolor' => $user->getColor()
				);
			}
			return $app->json(array(
				'records' => $result,
				'status' => 'OK'
			), 200);
		}
		
		public function getDepenses($group_id, Application $app) {
			$json = NULL;
			$depenses = $app['dao.depense']->findByGroup($group_id);
			if (!$depenses)
				$json = $app->json(array(
					'status' => 'KO',
					'error' => 'Pas de dépense enregistrée dans le groupe identifié par l’id '.$group_id
				), 400);
			if ($json === NULL) {
				foreach ($depenses as $depense) {
					$records[] = array(
						'Id' => $depense->getId(),
						'Montant' => $depense->getMontant(),
						'Payeur' => $depense->getUserId(),
						'Concernes' => implode(',', $depense->getUsers()),
						'Date' => $depense->getDate(),
						'nbConcernes' => count($depense->getUsers()),
						'usergroup' => $app['dao.group']->get($group_id)->getName(),
						'Description' => $depense->getName()
					);
				}
				$json = $app->json(array(
					'records' => $records,
					'status' => 'OK'
				), 200);
			}
			return $json;
		}
		
	}
	
?>

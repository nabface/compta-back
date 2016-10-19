<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Compta\Domain\Depense;
	use Compta\Domain\Group;
	use Compta\Domain\User;
	
	class APIControllerCreate {
		
		private function missingParameter(array $params, Request $request, Application $app) {
			foreach ($params as $param) {
				if (!$request->request->has($param)) {
					return $app->json(array(
						'status' => 'KO',
						'error' => 'Paramètre requis manquant : '.$param
					), 400);
				}
			}
			return NULL;
		}
		
		private function successfulOperation($result, $app) {
			return $app->json(array(
				'records' => $result,
				'status' => 'OK'
			), 201);
		}
		
		public function addGroup(Request $request, Application $app) {
			$params = ['name'];
			$json = $this->missingParameter($params, $request, $app);
			if ($json === NULL ) {
				$group = ($request->request->has('id')) ?
					$app['dao.group']->get($request->request->get('id')) :
					new Group() ;
				$group->setName($request->request->get('name'));
				$app['dao.group']->save($group);
				$result = array(
					'id' => $group->getId(),
					'name' => $group->getName()
				);
				$json = $this->successfulOperation($result, $app);
			}
			return $json;
		}
		
		public function addUser(Request $request, Application $app) {
			$params = ['username', 'usercolor', 'usergroup'];
			$json = $this->missingParameter($params, $request, $app);
			if ($json === NULL ) {
				$user = ($request->request->has('Id')) ?
					$app['dao.user']->get($request->request->get('Id')) :
					new User() ;
				$usergroup = $request->request->get('usergroup');
				$group = $app['dao.group']->get($usergroup);
				if (!$group) {
					$json = $app->json(array(
						'status' => 'KO',
						'error' => 'Groupe inconnu : '.$usergroup
					), 400);
				}
				else {
					$group_id = $group->getId();
					$user->setName($request->request->get('username'))
						   ->setColor($request->request->get('usercolor'))
						   ->addGroup($group_id);
					$app['dao.user']->save($user);
					$usergroups = [];
					foreach ($user->getGroups() as $group) {
						$usergroups[] = $app['dao.group']->get($group)->getName();
					}
					$result = array(
						'Id' => $user->getId(),
						'username' => $user->getName(),
						'usercolor' => $user->getColor(),
						'usergroups' => $usergroups
					);
					$json = $this->successfulOperation($result, $app);
				}
			}
			return $json;
		}
		
		public function addDepense(Request $request, Application $app) {
			$params = [
				'Montant',
				'Description',
				'usergroup',
				'Payeur',
				'Concernes'
			];
			$json = $this->missingParameter($params, $request, $app);
			if ($json === NULL ) {
				$date = ($request->request->has('Date')) ?
					$request->request->get('Date') :
					time() ;
				$users = explode(',', $request->request->get('Concernes'));
				$depense = ($request->request->has('Id')) ?
					$app['dao.depense']->get($request->request->get('Id')) :
					new Depense() ;
				$depense->setMontant($request->request->get('Montant'))
					      ->setDate($date)
					      ->setName($request->request->get('Description'))
					      ->setGroupId($request->request->get('usergroup'))
					      ->setUserId($request->request->get('Payeur'))
					      ->setUsers($request->request->get('Concernes'));
				$app['dao.depense']->save($depense);
				$result = array(
					'Id' => $depense->getId(),
					'Montant' => $group->getMontant(),
					'Date' => $depense->getDate(),
					'Description' => $depense->getName(),
					'usergroup' => $depense->getGroupId(),
					'Payeur' => $depense->getUserId(),
					'Concernes' => $depense->getUsers(),
				);
				$json = $this->successfulOperation($result, $app);
			}
		}
		
	}
	
?>

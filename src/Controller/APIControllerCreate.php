<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Compta\Domain\Depense;
	use Compta\Domain\Group;
	use Compta\Domain\User;
	
	class APIControllerCreate {
		
		use ParseJSON;
		use Security;
		
		private function wrongGroup(Request $request, Application $app) {
			$usergroup = $request->request->get('usergroup');
			$group = $app['dao.group']->get($usergroup);
			if (!$group) {
				return $app->json(array(
					'status' => 'KO',
					'error' => 'Groupe inconnu : '.$usergroup
				), 400);
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
			$json = $this->isLoggedIn($request, $app);
			if ($json === NULL ) {
				$params = ['name'];
				$json = $this->missingParameter($params, $request, $app);
			}
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
			$json = $this->isLoggedIn($request, $app);
			if ($json === NULL ) {
				$params = ['username', 'usercolor', 'usergroup'];
				$json = $this->missingParameter($params, $request, $app);
			}
			if ($json === NULL ) $json = $this->wrongGroup($request, $app);
			if ($json === NULL ) {
				$user = ($request->request->has('Id')) ?
					$app['dao.user']->get($request->request->get('Id')) :
					new User() ;
				$group = $app['dao.group']->get($request->request->get('usergroup'))
				                          ->getId();
				$user->setName($request->request->get('username'))
					   ->setColor($request->request->get('usercolor'))
					   ->addGroup($group);
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
			return $json;
		}
		
		public function addDepense(Request $request, Application $app) {
			$json = $this->isLoggedIn($request, $app);
			if ($json === NULL ) {
				$params = [
					'Montant',
					'Description',
					'usergroup',
					'Payeur',
					'Concernes'
				];
				$json = $this->missingParameter($params, $request, $app);
			}
			if ($json === NULL ) $json = $this->wrongGroup($request, $app);
			if ($json === NULL ) {
				$depense = ($request->request->has('Id')) ?
					$app['dao.depense']->get($request->request->get('Id')) :
					new Depense() ;
				$date = ($request->request->has('Date')) ?
					$request->request->get('Date') :
					time() ;
				$users = explode(',', $request->request->get('Concernes'));
				$group = $app['dao.group']->get($request->request->get('usergroup'))
				                          ->getId();
				$depense->setMontant($request->request->get('Montant'))
				        ->setDate($date)
				        ->setName($request->request->get('Description'))
				        ->setGroupId($group)
				        ->setUserId($request->request->get('Payeur'));
				foreach ($users as $user) $depense->addUser($user);
				$app['dao.depense']->save($depense);
				$users = $depense->getUsers();
				$users_count = count($users);
				$users = implode(',', $users);
				$group = $app['dao.group']->get($depense->getGroupId())->getName();
				$result = array(
					'Id' => $depense->getId(),
					'Montant' => $depense->getMontant(),
					'Payeur' => $depense->getUserId(),
					'Concernes' => $users,
					'Date' => $depense->getDate(),
					'nbConcernes' => $users_count,
					'usergroup' => $group,
					'Description' => $depense->getName()
				);
				$json = $this->successfulOperation($result, $app);
			}
			return $json;
		}
		
	}
	
?>

<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	use Compta\Domain\Depense;
	use Compta\Domain\Group;
	use Compta\Domain\User;
	
	class ApiController {
		
		public function getDepenses($group_id, Application $app) {
			$depenses = $app['dao.depense']->findByGroup($group_id);
			return $app->json($depenses);
		}
		
		public function getUsers($group_id, Application $app) {
			$users = $app['dao.user']->findByGroup($group_id);
			return $app->json(array(
				'records' => $users
			), 200);
		}
		
		public function addGroup(Request $request, Application $app) {
			if (!$request->request->has('name'))
				return $app->json('Missing required parameter: name', 400);
			else
				$name = $request->request->get('name');
			$group = new Group();
			$group->setName($name);
			$app['dao.group']->save($group);
			return $app->json(array(
				'id' => $group->getId(),
				'name' => $group->getName()
			), 201);
		}
		
		public function addDepense(Request $request, Application $app) {
			if (!$request->request->has('Montant'))
				return $app->json('Missing required parameter: Montant', 400);
			else
				$montant = $request->request->get('Montant');
			$date = ($request->request->has('Date')) ?
				$request->request->get('Date') :
				time() ;
			if (!$request->request->has('Description'))
				return $app->json('Missing required parameter: Description', 400);
			else
				$name = $request->request->get('Description');
			if (!$request->request->has('usergroup'))
				return $app->json('Missing required parameter: usergroup', 400);
			else
				$group_id = $request->request->get('usergroup');
			if (!$request->request->has('Payeur'))
				return $app->json('Missing required parameter: Payeur', 400);
			else
				$user_id = $request->request->get('Payeur');
			if (!$request->request->has('Concernes'))
				return $app->json('Missing required parameter: Concernes', 400);
			else
				$users = explode(',', $request->request->get('Concernes'));
			$depense = new Depense();
			$depense->setMontant($montant)
			        ->setDate($date)
			        ->setName($name)
			        ->setGroupId($group_id)
			        ->setUserId($user_id)
			        ->setUsers($users);
			$app['dao.depense']->save($depense);
			return $app->json(array(
				'id' => $depense->getId(),
				'montant' => $group->getMontant(),
				'date' => $depense->getDate(),
				'name' => $depense->getName(),
				'group_id' => $depense->getGroupId(),
				'user_id' => $depense->getUserId(),
				'users' => $depense->getUsers(),
			), 201);
		}
		
		public function addUser(Request $request, Application $app) {
			if (!$request->request->has('username'))
				return $app->json('Missing required parameter: username', 400);
			else
				$name = $request->request->get('username');
			if (!$request->request->has('usercolor'))
				return $app->json('Missing required parameter: usercolor', 400);
			else
				$color_id = $request->request->get('usercolor');
			if (!$request->request->has('usergroup'))
				return $app->json('Missing required parameter: usergroup', 400);
			else
				$group_id = $request->request->get('usergroup');
			$user = new User();
			$user->setName($name)
			     ->setColor($color_id)
			     ->addGroup($group_id);
			$app['dao.user']->save($user);
			return $app->json(array(
				'id' => $user->getId(),
				'name' => $user->getName(),
				'color_id' => $user->getColorId(),
				'groups' => $user->getGroups()
			), 201);
		}
		
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

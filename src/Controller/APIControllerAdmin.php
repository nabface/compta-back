<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	
	class APIControllerAdmin {
		
		use ParseJSON;
		
		public function login(Request $request, Application $app) {
			$params = ['name','password'];
			$json = $this->missingParameter($params, $request, $app);
			if ($json === NULL) {
				$login = $request->request->get('name');
				$password = $request->request->get('password');
				if (
					!isset($app['admin'][$login]) ||
					$app['admin'][$login] != $password
				) {
					$json = $app->json(array(
						'status' => 'KO',
						'error' => 'Mot de passe incorrect pour l’utilisateur '.$login
					), 400);
				}
				else {
					$key = base64_encode(random_bytes(64));
					$_SESSION['api.key'] = $key;
					$json = $app->json(array(
						'key' => $key,
						'status' => 'OK'
					), 200);
				}
			}
			return $json;
		}
		
		public function logout(Application $app) {
			if (isset($_SESSION['api.key'])) unset($_SESSION['api.key']);
			return $app->json(array(
				'status' => 'OK'
			), 200);
		}
		
	}
	
?>

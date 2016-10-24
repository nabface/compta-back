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
					$keyexpiration = time() + 1500;
					$keylist = fopen(__DIR__.'/../../cache/keylist.txt', 'a');
					fwrite($keylist, $key."\n".$keyexpiration."\n");
					fclose($keylist);
					$json = $app->json(array(
						'key' => $key,
						'status' => 'OK'
					), 200);
				}
			}
			return $json;
		}
		
		public function logout(Request $request, Application $app) {
			if (!$request->headers->has('apikey')) {
				$json = $app->json(array(
					'status' => 'KO',
					'error' => 'Le header \'apikey\' n’est pas défini'
				), 400);
			}
			else {
				$key = $request->headers->get('apikey');
				$found = false;
				$keylist = file(__DIR__.'/../../cache/keylist.txt');
				$keylist = array_map("rtrim", $keylist);
				$length = count($keylist);
				$file = fopen(__DIR__.'/../../cache/keylist.txt', 'w');
				for ($i = 0; $i < $length; $i += 2) {
					if ($keylist[$i] != $key)
						fwrite($file, $keylist[$i]."\n".$keylist[($i + 1)]."\n");
					else $found = true;
				}
				fclose($file);
				if ($found)
					$json = $app->json(array(
						'status' => 'OK'
					), 200);
				else
					$json = $app->json(array(
						'status' => 'KO',
						'error' => 'La clé d’API fournie n’est pas reconnue'
					), 400);
			}
			return $json;
		}
		
	}
	
?>

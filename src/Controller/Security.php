<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	
	trait Security {
		
		protected function getKeylist(Application $app) {
			return array_map("rtrim", file($app['keylist']));
		}
		
		protected function isLoggedIn(Request $request, Application $app) {
			if (!$request->headers->has('apikey'))
				return $app->json(array(
					'status' => 'KO',
					'error' => 'Le header \'apikey\' n’est pas défini'
				), 400);
			$key = $request->headers->get('apikey');
			$found = false;
			$keylist = $this->getKeylist($app);
			$length = count($keylist);
			for ($i = 0; $i < $length; $i += 2) {
				if ($keylist[$i] == $key) return $this->hasKeyExpired($i, $app, true);
			}
			return $app->json(array(
				'status' => 'KO',
				'error' => 'La clé d’API fournie n’est pas reconnue'
			), 400);
		}
		
		protected function hasKeyExpired($index, Application $app, $reset = false) {
			$keylist = $this->getKeylist($app);
			if ($reset || $keylist[($index + 1)] < time()) {
				$file = fopen($app['keylist'], 'w');
				$length = count($keylist);
			}
			if ($keylist[($index + 1)] < time()) {
				for ($i = 0; $i < $length; $i += 2) {
					if ($i != $index)
						fwrite($file, $keylist[$i]."\n".$keylist[($i + 1)]."\n");
				}
				fclose($file);
				return $app->json(array(
					'status' => 'KO',
					'error' => 'Votre session a expiré'
				), 400);
			}
			elseif ($reset) {
				for ($i = 0; $i < $length; $i += 2) {
					$keyexpiration = ($i == $index)?
						time() + $app['keyexpiration']:
						$keylist[($i + 1)];
					fwrite($file, $keylist[$i]."\n".$keyexpiration."\n");
				}
				fclose($file);
			}
			return NULL;
		}
		
	}
	
?>

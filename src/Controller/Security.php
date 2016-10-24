<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	
	trait Security {
		
		protected function isLoggedIn(Request $request, Application $app) {
			if (!$request->headers->has('apikey'))
				return $app->json(array(
					'status' => 'KO',
					'error' => 'Le header \'apikey\' n’est pas défini'
				), 400);
			$key = $request->headers->get('apikey');
			$found = false;
			$keylist = file(__DIR__.'/../../cache/keylist.txt');
			$keylist = array_map("rtrim", $keylist);
			$length = count($keylist);
			for ($i = 0; $i < $length; $i += 2) {
				if ($keylist[$i] == $key) return $this->hasKeyExpired($i, $app);
			}
			return $app->json(array(
				'status' => 'KO',
				'error' => 'La clé d’API fournie n’est pas reconnue'
			), 400);
		}
		
		protected function hasKeyExpired($index, Application $app) {
			$keylist = file(__DIR__.'/../../cache/keylist.txt');
			$keylist = array_map("rtrim", $keylist);
			if ($keylist[($index + 1)] < time()) {
				$file = fopen(__DIR__.'/../../cache/keylist.txt', 'w');
				$length = count($keylist);
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
			return $app->json(array(
				'status' => 'KO',
				'error' => 'La clé d’API fournie n’est pas reconnue'
			), 400);
		}
		
	}
	
?>

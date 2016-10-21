<?php
	
	namespace Compta\Controller;
	
	use Silex\Application;
	use Symfony\Component\HttpFoundation\Request;
	
	trait ParseJSON {
		
		protected function missingParameter(
			array $params,
			Request $request,
			Application $app
		) {
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
		
	}
	
?>

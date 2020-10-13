<?php 

/*-
-------------------------------------
Getting Controllers and Actions
-------------------------------------
-*/

class Bootstrap {

	public function __construct($url, $action) {

		if (isset($url)) {

			$controller = substr($action,0,strpos($action, "@"));
			$method     = substr($action,strpos($action, "@")+1);
			$url        = explode('/', rtrim($url,'/'));

			if (file_exists('Controllers/'.$controller.'.php')) {

				// Instancing the Controller Obj
				$controller = new $controller();

				// calling methods within controller
			 	if (!empty($method)) {

			 		if (method_exists($controller, $method)) {
			 			$controller->$method(end($url));
			 		}	
			 	}
			
			}
		}
	}


}



 ?>
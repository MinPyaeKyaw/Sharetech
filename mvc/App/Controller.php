<?php 

/*-
----
Controller Class
*/
class Controller {

	/*-
	----
	Instancing View Object and Api Object Get the Implements
	*/
	public function __construct() {
		$this->view = new View();
		$this->api = new Api();
	}

	/*-
	----
	Redirecting the wished pages
	*/
	public function redirect($url) {
		$path      = $_GET['url'];
		$pathArray = explode('/', rtrim($path, '/'));
		$toBack    = '../';
		$routing   = '';

		for ($i=0; $i<count($pathArray)-1; $i++) { 
			$routing .= $toBack;
		}

		return header("location: $routing".$url);

	}

}

 ?>
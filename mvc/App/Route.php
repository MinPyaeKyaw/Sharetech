<?php 

/*-
----
Route class
*/
class Route {

	/*-
	----
	Constructor for getting url and controller from Route/web.php
	*/
	public function __construct() {
		$id = explode('/', @$_GET['url']);
		$id = end($id);

		if (empty($_GET['url'])) {
			self::go('home','HomeController@index');
		}else {
			include('Route/web.php');
		}
		// $_SERVER['REQUEST_METHOD'];
	}

	/*-
	----
	go Function to route and get the controllers
	*/
	public static function go($url, $controller) {
		$inputURL = Security::securingURL(@$_GET['url']);
		if ($url == $inputURL || empty($inputURL)) {
			new Bootstrap($url, $controller);
		}
	}

	/*-
	----
	route function to route the pages form everywhere
	*/
	public static function route($url) {
		$path      = $_GET['url'];
		$pathArray = explode('/', rtrim($path, '/'));
		$toBack    = '../';
		$routing   = '';

		if (empty($path)) {
			header("location: home");
		}else {
			for ($i=0; $i<count($pathArray)-1; $i++) { 
				$routing .= $toBack;
			}

			echo $routing .= $url;
		}
		
	}

	/*-
	----
	route function for echo string to route the pages form everywhere
	*/
	public static function routeStr($url) {
		$path      = $_GET['url'];
		$pathArray = explode('/', rtrim($path, '/'));
		$toBack    = '../';
		$routing   = '';

		if (empty($path)) {
			header("location: home");
		}else {
			for ($i=0; $i<count($pathArray)-1; $i++) { 
				$routing .= $toBack;
			}

			return $routing .= $url;
		}
		
	}

	/*-
	----
	route function for api
	*/
	public static function api($url, $controller) {
		$inputURL = Security::securingURL(@$_GET['url']);
		if ($url == $inputURL || empty($inputURL)) {
			new Bootstrap($url, $controller);
		}
	}

} 

 ?>
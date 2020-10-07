<?php 

/*-
----
FacadeApp class
*/
class FacadeApp {

	public function __construct() {

		//Instantiating Route class form App/Route
		new Route();

		//Getting Authentication
		$auth = scandir('Authentication');
		for($i=2; $i<count($auth); $i++) {
			if ($auth[$i] == "Authentication.php") {
				continue;
			}
			pathinfo($auth[$i], PATHINFO_FILENAME)::authCheck();
		}

	}

}
// End of FacadeApp

 ?>
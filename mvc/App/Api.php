<?php 

/*-
----
Api Class
*/
class Api {

	/*-
	----
	Exporting results to API
	*/
	public function request($path) {
		include("api/".$path.".php");
	}

}

 ?>
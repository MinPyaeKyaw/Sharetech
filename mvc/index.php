<?php

/*-
----
Getting started session
*/
session_start();

/*-
-------------------------------------
Autoloading Classes
-------------------------------------
-*/
spl_autoload_register(function($class) {

	/*-
	----
	Getting Filename
	*/
	$filename = ucfirst($class).'.php';
	
	/*-
	----
	Getting Paths
	*/
	$paths = array(
		'api/',
		'App/',
		'App/Models/',
		'App/Security/',
		'Controllers/',
		'Models/',
		'Views/',
		'Database/',
		'Route/',
		'Authentication/'
		);

	/*-
	----
	Including the Classes
	*/
	foreach ($paths as $path) {
		if (file_exists($path.$filename)) {
			include($path.$filename);
		}
	}


});

new FacadeApp();


 ?>
<?php 

/*-
----
View Class
*/
class View {

	/*-
	----
	Rendering the View Files from Here
	*/
	public function render($path, $layout = null) {

		if ($layout == null) {
			$view = $path;
			include('Views/defaultLayout.php');
		}else {
			$view = $path;
			include('Views/'.$layout.'.php');
		}

	}

}

 ?>
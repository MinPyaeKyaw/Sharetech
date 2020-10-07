<?php 

/*-
----
Controller Class
*/
class Controller {

	/*-
	----
	Instancing View Object and Get the Implements
	*/
	public function __construct() {
		$this->view = new View();
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

	/*-
    ----
    File Uploader
    */
    public function fileUploader($filename, $tmp) {
        if (Security::escapeFile($filename) == true) {
            $name = Security::setFilename($filename);
            move_uploaded_file($tmp, 'Public/Images/'.$name);
            return $name;
        }else {
            return false;
        }
    }

    /*-
    ----
    Multi File Uploader
    */
    public function multiUploader($filename, $tmp) {
    	$fileCount = count($filename);
    	$files     = array();
    	$flag      = true;
		for ($i=0; $i<$fileCount; $i++) { 
			if (Security::escapeFile($filename[$i]) == true) {
	            $name = Security::setFilename($filename[$i]);
	            move_uploaded_file($tmp[$i], 'Public/Images/'.$name);
	            $files[] = $name;
	            $flag = true;
	        }else {
	        	$flag = false;
	        }
		}

		if ($flag == true) {
			return $files;
		}else {
			return false;
		}
		
    }


}

 ?>
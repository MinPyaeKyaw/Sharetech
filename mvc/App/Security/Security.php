<?php 


/*-
----
Security Class
*/
class Security {

	/*-
	----
	Extension Blacklist
	*/
	static private $blackListExtensions = array('PHP','HTACCESS','HTML','CSS','JS','XML','JSON','CSV','PDF','BIN','EXE','TXT','SH','PL','PY','CGI','ZIP','RAR','GIF');


	/*-
	----
	Meta Characters
	*/
	static private $meta = array('!','(',')','{','}','[',']','=',':',';','^','*','`','|','<','>','~','?','\'','"','#','-');

	/*-
	----
	Getting File Extension
	*/
	static public function getExtension($filename) {
		$filename = strtoupper($filename);
		return pathinfo($filename, PATHINFO_EXTENSION);
	}

	/*-
	----
	Getting Filename
	*/
	static public function getBasename($filename) {
		$filename  = strtolower($filename);
		$extension = self::getExtension($filename);
		return basename($filename, $extension);
	}

	/*-
	----
	Defining Filename
	*/
	static public function setFilename($filename) {
		$extension     = pathinfo($filename, PATHINFO_EXTENSION);
		$filename      = basename($filename);
		$letters   	   = "1234567890qwertyuioplkjhgfdsazxcvbnm";
		$shuffleLetter = substr(str_shuffle($letters),0,15); 
		$filename      = rand().$shuffleLetter.'.'.$extension;

		return $filename;
	}

	/*-
	----
	Escaping Filename and Extension
	*/
	static public function escapeFile($filename) {
		$flag;

		$extension = self::getExtension($filename);
		$basename  = self::getBasename($filename);


		if ($extension != 'JPG' && $extension != 'JPEG' && $extension != 'PNG' && $extension != 'MP4') {
			$flag = false;
		}
		elseif (empty($extension)) {
			$flag = false;
		}
		else {
			foreach (self::$blackListExtensions as $blackList) {
				if (strpos($basename, '.'.$blackList) == true) {
					$flag = false;
					break;
				}else {
					$flag = true;
				}
			}		
		}
			
		if ($flag == true) {
			return true;
		}else {
			return false;
		}

	}




	/*-
	----
	Regenerating Session
	*/
	static public function reSession() {
		return session_regenerate_id(true);
	}




	/*-
	----
	Regenerating Session
	*/
	static public function securingURL($url) {
			$url   = strip_tags($url);
			$url   = preg_replace("/<script\b[^>]*>(.*?)<\/script>/", " ", $url);
			$url   = preg_replace("/<img[^>]+\>/", " ", $url);
			$url   = htmlspecialchars($url);

			return $url;
		
	}




	// escape injections
	static public function escapeInput($input) {
		foreach (self::$meta as $shit) {
			$input = str_replace($shit, '', $input);
		}
		$input = addslashes($input);
		$input = str_replace('--', '', $input);
		$input = rtrim($input, '--');
		$input = str_replace('#', '', $input);
		$input = rtrim($input, '#');
		$input = str_replace('/*', '', $input);
		$input = rtrim($input, '/*');
		$input = strip_tags($input);
		$input = preg_replace("/<script\b[^>]*>(.*?)<\/script>/", "", $input);
		$input = preg_replace("/<img[^>]+\>/", "", $input);
		$input = htmlspecialchars($input);
		$input = trim($input);

		return $input;
	}
	// End of escape injections


	/*-
	----
	Checking the input is link or not
	*/
	static public function isUrl($input) {
		if (filter_var($input, FILTER_VALIDATE_URL)) {
			return false;
		}else {
			return true;
		}
	}



	/*-
	----
	Hashing
	*/
	static private function hash($input) {
		return $result = md5($input);
	}

	/*-
	----
	Generating Token
	*/
	static private function token() {
		$letter        = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
		return $token  = str_shuffle($letter);
	}

	/*-
	----
	Verifying CSRF Token
	*/
	static public function verifyCSRF($token) {

		if($token == $_COOKIE['csrf']) {
			return true;
		}else{
			return false;
		}		
	}

	/*-
	----
	CSRF Form input
	*/
	static public function csrf() {
		if (!isset($_COOKIE['csrf'])) {
			$token = self::hash(self::token());
			setcookie('csrf', $token);	
		}else {
			$token = $_COOKIE['csrf'];
		}

		echo "<input type='hidden' name='csrf' value='{$token}'>";

	}
	


}
//End of Security Class

 ?>

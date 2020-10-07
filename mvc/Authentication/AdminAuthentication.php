<?php 

/*-
----
AdminAuthenticatin class
*/
class AdminAuthentication implements Authentication {

	/*-
	----
	Define your redirect page
	*/
	public static $redirectPage = "adminLogin";

	/*-
	----
	Define your Auth Pages
	*/
	public static $authPages = array(
		'adver',
		'createArticle',
		'createContent',
		'dashboard',
		'draft',
		'history',
		'report',
		'updateCourse'
	);

	/*-
	----
	Log in function
	*/
	public static function login($email, $password) {
		$email    = Security::escapeInput($email);
		$password = Security::escapeInput($password);
		$email    = Security::escapeXss($email);
		$password = Security::escapeXss($password);

	}

	/*-
	----
	Sign up function
	*/
	public static function signup($username, $email, $password) {
		$username = Security::escapeInput($username);
		$email    = Security::escapeInput($email);
		$password = Security::escapeInput($password);
		$username = Security::escapeXss($username);
		$email    = Security::escapeXss($email);
		$password = Security::escapeXss($password);
	}

	public static function rememberMe() {

	}

	/*-
	----
	Log out function
	*/
	public static function logout() {
		unset($_COOKIE['id']);
		unset($_COOKIE['name']);
	}

	/*-
	----
	Checking Authentication
	*/
	public static function authCheck() {

		foreach (self::$authPages as $value) {
			if (@$_GET['url'] == $value) {
				if (!isset($_COOKIE['id'])) {
					self::redirect(self::$redirectPage);
				}
				break;
			}else {
				continue;
			}
		}

	}

	public static function forgetPassword() {

	}

	/*-
	----
	Redirecting the login page
	*/
	public static function redirect($url) {
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
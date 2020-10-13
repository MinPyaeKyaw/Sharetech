<?php 

/*-
----
Authentication Interface
*/
interface Authentication {

	public static function login($username, $password);

	public static function signup($username, $email, $password);

	public static function rememberMe();

	public static function logout();

	public static function forgetPassword();

	public static function authCheck();

	public static function redirect($url);

}

 ?>
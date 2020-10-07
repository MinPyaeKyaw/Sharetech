<?php 


/*-
----
Database Class
*/
class DB implements DatabaseInterface {

	private static $database;
	private static $hostname;
	private static $username;
	private static $password;
	private static $connect;

	/*-
	----
	Connection to the Databases
	*/
	public static function connect($database) {
		self::$database = $database;
		self::$hostname = 'localhost';
		self::$username = 'root';
		self::$password = '';

		try {
			self::$connect = new PDO('mysql:host='.self::$hostname.';dbname='.self::$database.';charset=utf8',self::$username,self::$password);	
		} catch (Exception $e) {
			echo 'Message: '.$e->getMessage();
		}

		return self::$connect;
	}

}

 ?>
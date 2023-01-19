<?php

class Db
{
	private static $host = "localhost";
	private static $dbname = "ecommerce";
	private static $username = "root";
	private static $password = "";
	private static $con = "";

	public static function connect(){
		if(null == self::$con){
			try{
				self::$con = new PDO("mysql:host=".self::$host.";dbname=".self::$dbname,self::$username,self::$password);
				self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch(PDOException $pdo_error){
				echo $pdo_error->getMessage();
			}
		}

		return self::$con;
	}

	public static function disconnect(){
		die(self::$con);
	}
}

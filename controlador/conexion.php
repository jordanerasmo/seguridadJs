<?php
class Conexion{
	static $mysqli;
	public static function abrir(){
		$host = '127.0.0.1';
		$user = 'root';
		$pass = '';
		$bbdd = 'seguridadd';
		$mysqli = new mysqli($host,$user,$pass,$bbdd);
		return $mysqli;
	}
}
?>
<?php
include_once("config.php");

try{
	$param = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

	$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD, $param);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

} catch(PDOException $e) {
	die('Erreur :' .$e->getMessage());
} 

setlocale(LC_ALL, 'fra');
setlocale(LC_TIME, 'fra', 'fr_FR');
ini_set('date.timezone', 'Europe/Berlin'); ?>

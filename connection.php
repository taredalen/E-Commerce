<?php

$db_host="localhost";
$db_user="root";
$db_password="";
$db_name="ProjectPHP";

try {
	$db = new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_password);
	$db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOEXCEPTION $e) {
	echo $e;
}


try {
	$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
}
catch(EXCEPTION $e) {
	echo $e;
}
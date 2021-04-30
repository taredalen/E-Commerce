<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "ProjectPHP";

try {
	$db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sql = "CREATE TABLE if not exists Client(
                             id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                             nom VARCHAR(500) NOT NULL,
                             prenom VARCHAR(500) NOT NULL,
                             mail VARCHAR(500) NOT NULL,
                             numero VARCHAR(500) NOT NULL,
                             rue VARCHAR(500) NOT NULL,
                             ville VARCHAR(500) NOT NULL,
                             code VARCHAR(500) NOT NULL,
                             situation VARCHAR(500),
                             naissance DATE,
                             sexe VARCHAR(500),
                             password varchar(500) NOT NULL)";
	$db->exec($sql);

	$sql2 = "CREATE TABLE if not exists Commentaire(
                             id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                             nom VARCHAR(500) NOT NULL,
                             prenom VARCHAR(500) NOT NULL,
                             mail VARCHAR(500) NOT NULL,
                             commentaire VARCHAR(900) NOT NULL)";
	$db->exec($sql2);

	$sql3 = "CREATE TABLE if not exists Administrateur(
                             id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                             mail VARCHAR(500) NOT NULL,
                             password varchar(500) NOT NULL)";
	$db->exec($sql3);

}
catch (PDOEXCEPTION $e) {
}

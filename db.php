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

    $sql4 = "INSERT INTO Administrateur (id, mail, password) VALUES (1,'admin@gmail.com', 'admin')";
    $db->exec($sql4);

    $sql5 = "CREATE TABLE if not exists Produits(
                         id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                         refe VARCHAR(500) NOT NULL,
                         libelle VARCHAR(500) NOT NULL,
                         cat VARCHAR(500),
                         marque VARCHAR(500),
                         stock INTEGER,
                         prix FLOAT,
                         TVA INTEGER,
                         descr VARCHAR(500) NOT NULL)";
    $db->exec($sql5);

    $sql6 = "CREATE TABLE if not exists Commande(
                         id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                         nom VARCHAR(500) NOT NULL,
                         prenom VARCHAR(500) NOT NULL,
                         mail VARCHAR(500) NOT NULL,
                         rue VARCHAR(500) NOT NULL,
                         ville VARCHAR(500) NOT NULL,
                         code VARCHAR(500) NOT NULL,
                         refe VARCHAR(500) NOT NULL,
                         libelle VARCHAR(500) NOT NULL,
                         quantité FLOAT,
                         prix FLOAT";
    $db->exec($sql6);

}
catch (PDOEXCEPTION $e) {
}

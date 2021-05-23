<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "ProjectPHP";

// Create connection
$db = new mysqli($db_host, $db_user, $db_password);
// Create database
$sql = "CREATE DATABASE ProjectPHP";
$result = mysqli_query($db, $sql);
$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

// Les requêtes
$sql1 = "CREATE TABLE if not exists Client(
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
$resultat1 = mysqli_query($connect, $sql1); //execute la requete

$sql2 = "CREATE TABLE if not exists Commentaire(
                         id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                         nom VARCHAR(500) NOT NULL,
                         prenom VARCHAR(500) NOT NULL,
                         mail VARCHAR(500) NOT NULL,
                         commentaire VARCHAR(2000) NOT NULL)";
$resultat2 = mysqli_query($connect, $sql2);

$sql3 = "CREATE TABLE if not exists Administrateur(
                         id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                         mail VARCHAR(500) NOT NULL,
                         password varchar(500) NOT NULL)";
$resultat3 = mysqli_query($connect, $sql3);

$sql4 = "INSERT INTO Administrateur (id, mail, password) VALUES (1,'admin@gmail.com', 'admin')";
$resultat4 = mysqli_query($connect, $sql4); //creation du compte admin

$sql5 = "CREATE TABLE if not exists Produits(
                         id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                         refe VARCHAR(500) NOT NULL,
                         libelle VARCHAR(500) NOT NULL,
                         cat VARCHAR(500),
                         marque VARCHAR(500),
                         stock INTEGER,
                         prix FLOAT,
                         TVA INTEGER,
                         descr VARCHAR(500) NOT NULL
                         content LONGBLOB DEFAULT NULL)";

$resultat5 = mysqli_query($connect, $sql5); //Création des produits

$sql6 = "CREATE TABLE if not exists Commande(
                         id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                         id_client INT UNSIGNED,
                         id_produit INT UNSIGNED,
                         quantite_produit INT,
                         date_commande DATE,
                         prix FLOAT,
                         FOREIGN KEY(id_client) REFERENCES Client(id),
                         FOREIGN KEY(id_produit) REFERENCES Produits(id))";
$resultat6 = mysqli_query($connect, $sql6); //Création des commandes

?>

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

$sql13 = "INSERT INTO Client (id, mail, password) VALUES (1,'admin@gmail.com', 'admin')";
$resultat13 = mysqli_query($connect, $sql13); //creation du compte admin

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
                         prix_unitaire FLOAT,
                         TVA INTEGER,
                         descr VARCHAR(2000) NOT NULL)";

$resultat5 = mysqli_query($connect, $sql5); //Création des produits

$sql6 = "CREATE TABLE if not exists Commande(
                         id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                         id_client INT UNSIGNED,
                         liste_id_produits_cmd VARCHAR(500),
                         date_commande DATE,
                         prix FLOAT,
                         FOREIGN KEY(id_client) REFERENCES Client(id))";
$resultat6 = mysqli_query($connect, $sql6); //Création des commandes

$sql7 = "INSERT INTO Produits (refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES ( '603a6C0ea#abf','HP Pavilion x360 14-dy0008nf', 'PC', 'HP', 17, 899,20,'Le HP Pavilion x360 14 convertible s’adapte à tous vos besoins pour vous permettre d’être productif sous n’importe quel angle. Regardez vos séries préférées aussi longtemps que vous le souhaitez grâce à HP Fast Charge. Avec ses deux haut-parleurs dotés d’un système audio par B&O, cet ordinateur portable vous offre le son et l’expérience de divertissement immersifs que vous recherchez. Conçu avec le souci du respect de l’environnement, le HP Pavilion x360 est fabriqué à partir de plastiques océaniques, durables et recyclés post-consommation')";
$resultat7 = mysqli_query($connect, $sql7); //creation d'un produit

$sql8 = "INSERT INTO Produits (refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES ( '603j122aa#abb','Stylet inclinable rechargeable HP MPP2.0 (noir)', 'Autre', 'HP', 3, 399,20,'Laissez libre cours à votre créativité avec la technologie MPP2.0, qui réduit les délais, optimise la transition entre les couleurs et améliore la réactivité')";
$resultat8 = mysqli_query($connect, $sql8); //creation d'un produit

$sql9 = "INSERT INTO Produits (refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES ( '601mr71b#nhc','HP OfficeJet Pro 9020 tout-en-un', 'Imprimante', 'HP', 77, 279,20,'Une imprimante intelligente révolutionnaire. Gagnez du temps avec les raccourcis Smart Tasks. Bénéficiez d’une numérisation recto-verso en une seule passe, d’une impression mobile en toute simplicité,de connexions sans faille, de la sécurité HP, la meilleure de sa catégorie. Économisez jusqu’à 70 % sur vos cartouches d’encre')";
$resultat9 = mysqli_query($connect, $sql9); //creation d'un produit

$sql10= "INSERT INTO Produits (refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES ( '60#2228C02625','Canon PIXMA TS5151 - Blanc', 'Imprimante', 'Canon', 1, 79,20,'Imprimante multifonction familiale compacte et abordable avec connectivité intelligente pour imprimer, copier et numériser en toute simplicité à domicile.')";
$resultat10 = mysqli_query($connect, $sql10); //creation d'un produit

$sql11= "INSERT INTO Produits (refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES ( '60#2228C02625','Cartouche d’encre à haut rendement Canon PG-540XL/CL-541XL + Pack économique de papiers photo', 'Autre', 'Canon', 56, 11,20,'Tout ce dont votre imprimante a besoin dans un pack à prix réduit comprenant encres et papier photo.')";
$resultat11 = mysqli_query($connect, $sql11); //creation d'un produit

$sql12= "INSERT INTO Produits (refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES ( '6000008377391','Tapis de souris Repose-poignet Noir', 'Autre', 'Boulanger', 0, 6,20,'Repose poignet en gel pour un confort d’utilisation personnalisé : soulage les tensions au niveau du poignet.Tissu Lycra.')";
$resultat12 = mysqli_query($connect, $sql12); //creation d'un produit

?>

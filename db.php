<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "ProjectPHP";

try {
    // Create connection to server
    $db = mysqli_connect($db_host, $db_user, $db_password, $db_name);

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
    mysqli_query($db, $sql1); //execute la requete

    $sql2 = "CREATE TABLE if not exists Commentaire(
                             id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                             nom VARCHAR(500) NOT NULL,
                             prenom VARCHAR(500) NOT NULL,
                             mail VARCHAR(500) NOT NULL,
                             commentaire VARCHAR(2000) NOT NULL)";
    mysqli_query($db, $sql2);

    $sql3 = "CREATE TABLE if not exists Administrateur(
                             id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                             mail VARCHAR(500) NOT NULL,
                             password varchar(500) NOT NULL)";
    mysqli_query($db, $sql3);

    $sql4 = "INSERT INTO Administrateur (id, mail, password) VALUES (1,'admin@gmail.com', 'admin')";
    mysqli_query($db, $sql4); //creation du compte admin

    $sqlproduit = "CREATE TABLE if NOT EXISTS Produits(
                             id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                             refe VARCHAR(500) NOT NULL,
                             libelle VARCHAR(500) NOT NULL,
                             cat VARCHAR(500),
                             marque VARCHAR(500),
                             stock INT,
                             prix FLOAT,
                             TVA INTEGER,
                             descr VARCHAR(500),NOT NULL)";
    mysqli_query($db, $sqlproduit);


}
catch (EXCEPTION $e) {
    echo $e;
}
?>

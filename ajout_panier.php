<?php
require_once 'connection.php';
require_once 'db.php';

session_start();
$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_GET['id']; // get id through query string

$sql1 = "SELECT stock FROM Produits WHERE id='".$id."'";
$result = mysqli_query($connect, $sql1);
if (mysqli_num_rows($result) > 0){
    $quantite = $_GET['quantite'];

    if(empty($quantite) || $quantite=0){
        echo 'non';
        $errorMsg[]="Veuillez entrer une quantité du produit";
    }

    else {
        $id_client = "SELECT C.id FROM Client C
                    JOIN Commande Co ON Co.id_client = C.id";
        $id_produit = $id;
        $prix_produit = "SELECT prix FROM Produit WHERE id='{$id}'";
        $prix = $prix_produit * $quantite;

        //$sql = "INSERT INTO Commande (id_client, id_produit, quantite, date_commande, prix) VALUES ($id_client, $id_produit, $quantite, CURRENT_DATE(), $prix)";

        $stmt1 = mysqli_prepare($connect, $id_client);
        $stmt2 = mysqli_prepare($connect, $id_produit);
        //$stmt = mysqli_prepare($connect, $sql);
        if ($stmt1->execute() && $stmt2->execute()) {
            echo 'coucou';
            $successMsg = "Produit ajouté au panier avec succès";
            //header("refresh:2; gestion_commande.php");
        } else {
            $errorMsg[] = "Erreur";
        }
    }
}
?>
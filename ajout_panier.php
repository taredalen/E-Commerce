<?php
require_once 'connection.php';
require_once 'db.php';

session_start();
$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_GET['id']; // get id through query string

$sql1 = "SELECT stock FROM Produits WHERE id='".$id."'";
$result = mysqli_query($connect, $sql1);
if (mysqli_num_rows($result) > 0){
    $quantite = $_POST['quantite'];
    if(empty($quantite) || $quantite=0){
        mysqli_close($connect); // Close connection
        $errorMsg[]="Veuillez entrer une quantité du produit";
        header("location:gestion_commande.php?errorMsg=$errorMsg"); // redirects to liste_produit page
        exit;
    }
    else {
        $qtn = $_POST['quantite'];
        $id_client = $_SESSION['user_login'];
        $prix_produit = "SELECT prix*'{$qtn}' FROM Produits WHERE id='{$id}'";
        $sql = "INSERT INTO Commande (id_client, id_produit, quantite_produit, date_commande, prix) VALUES ($id_client, $id, $qtn, CURRENT_DATE(), ($prix_produit))";
        $stmt = mysqli_prepare($connect, $sql);
        if ($stmt->execute()) {
            mysqli_close($connect); // Close connection
            $successMsg = "Produit ajouté au panier avec succès";
            header("location:gestion_commande.php?successMsg=$successMsg"); // redirects to liste_produit page
            exit;
        } else {
            mysqli_close($connect); // Close connection
            $errorMsg[] = "Erreur";
            header("location:gestion_commande.php?errorMsg=$errorMsg"); // redirects to liste_produit page
            exit;
        }
    }
}
?>
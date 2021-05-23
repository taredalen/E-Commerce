<?php
require_once 'connection.php';
session_start();
$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_GET['id']; // get id produit
$id_client = $_SESSION['user_login'];

$sql2 = "SELECT quantite_produit FROM Panier_".$id_client." WHERE id_produit=".$id;
$result = mysqli_query($connect, $sql2);
$row = mysqli_fetch_assoc($result);
$qtn = $row['quantite_produit'];

$sql1 = "DELETE FROM Panier_".$id_client." WHERE id_produit=".$id;
$stmt1 = mysqli_prepare($connect, $sql1);
if($stmt1->execute()){
    $sql3 = "UPDATE Produits SET stock = stock+'{$qtn}' WHERE id='{$id}'";
    $stmt3 = mysqli_prepare($connect, $sql3);
    $stmt3->execute();

    mysqli_close($connect); // Close connection
    $successMsg = "Produit retiré du panier avec succès";
    header("location:consulter_panier.php?successMsg=$successMsg"); // redirects to liste_produit page
    exit;
}
?>

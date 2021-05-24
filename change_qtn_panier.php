<?php
require_once 'connection.php';
require_once 'db.php';

session_start();

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_SESSION['user_login'];
$qtn = $_GET['qtn'];

$sql2 = "SELECT Pa.id_produit, P.prix_unitaire FROM Panier_".$id." AS Pa
         JOIN Produits P ON P.id=Pa.id_produit";
$stmt2 = mysqli_prepare($connect,$sql2);
if(mysqli_stmt_execute($stmt2)==true){
    $result2 = mysqli_stmt_get_result($stmt2);
    while($row = mysqli_fetch_assoc($result2)){
        $nouveau_prix = $qtn*$row['prix_unitaire'];
        $sql3 = "update Panier_".$id." set quantite_produit=".$qtn.", prix=".$nouveau_prix." WHERE id_produit=".$row['id_produit'];
        $result3 = mysqli_query($connect, $sql3);
    }
    header("location:consulter_panier.php?qtn=$qtn");
}
?>
<?php
require_once 'connection.php';
require_once 'db.php';

session_start();

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_SESSION['user_login'];
$qtn = $_GET['qtn'];
$id_produit = $_GET['id_produit'];

$sql = "SELECT Pa.id_produit, P.prix_unitaire FROM Panier_".$id." AS Pa
         JOIN Produits P ON P.id=Pa.id_produit";
$stmt = mysqli_prepare($connect,$sql);
if(mysqli_stmt_execute($stmt)==true){
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)){
        if($row['id_produit']==$id_produit){
            $nouveau_prix = $qtn*$row['prix_unitaire'];
            $sql1 = "UPDATE Panier_".$id." SET quantite_produit=".$qtn.", prix=".$nouveau_prix." WHERE id_produit=".$row['id_produit'];
            $result1 = mysqli_query($connect, $sql1);
        }
    }
    header("location:consulter_panier.php");
}
?>
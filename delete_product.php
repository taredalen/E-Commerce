<?php
require_once 'connection.php';
require_once 'db.php';

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_GET['id']; // get id through query string
//$sql = mysqli_query($connect,"select * from Produits where id='$id'"); // select query
//$row = mysqli_fetch_array($sql); // fetch data

$sql1 = "SELECT stock FROM Produits WHERE id='".$id."'";
$result = mysqli_query($connect, $sql1);
if (mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        if($row["stock"]>0){
            mysqli_close($connect); // Close connection
            $errorMsg ="Le stock de ce produit n'est pas nul. Il ne peut dont pas être supprimé.";
            header("location:liste_produit.php?errorMsg=$errorMsg"); // redirects to liste_produit page
            exit;
        }
        else{
            $result1 = mysqli_query($connect,"DELETE FROM Produits WHERE id='".$id."'");
            if($result1=true) {
                mysqli_close($connect); // Close connection
                $successMsg = "Produit supprimé avec succès";
                header("location:liste_produit.php?successMsg=$successMsg"); // redirects to liste_produit page
                exit;
            }
            else {
                mysqli_close($connect); // Close connection
                $errorMsg="Erreur";
                header("location:liste_produit.php?errorMsg=$errorMsg"); // redirects to liste_produit page
                exit;
            }
        }
    }
}
?>
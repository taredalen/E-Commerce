<?php
require_once 'connection.php';
require_once 'db.php';

//connexion a la bdd et recuperation de l'id client
$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id_client = $_GET['id_client'];

if (isset($_POST['back'])) {
    header("Location: gestion_produit.php");
}

if (isset($_POST['valid'])){
    //requete 1
    $sql= "SELECT id_produit FROM Panier_".$id_client." WHERE id_client='{$id_client}'";
    $stmt = mysqli_prepare($connect, $sql);
    if(mysqli_stmt_execute($stmt)==true){
        $result = mysqli_stmt_get_result($stmt);
        $liste_prd="";
        while($row = mysqli_fetch_assoc($result)){
            if($row["id_produit"]>1){
                $liste_prd= $liste_prd.(string)$row['id_produit'].',';
            }
            else{
                $liste_prd= $liste_prd.(string)$row['id_produit'];
            }
        }
        echo $liste_prd;
    }
    else{
        $errorMsg = mysqli_stmt_error($stmt);
        header("location:consulter_panier.php?errorMsg=$errorMsg");
    }

//requete 2
    $sql1 = "SELECT SUM(prix) AS prix_tot FROM Panier_".$id_client;
    $stmt1 = mysqli_prepare($connect, $sql1);
    if(mysqli_stmt_execute($stmt1)==true){
        $result1 = mysqli_stmt_get_result($stmt1);
        $row = mysqli_fetch_assoc($result1);
        $prix_tot = $row['prix_tot'];
    }
    else{
        $errorMsg = mysqli_stmt_error($stmt1);
        header("location:consulter_panier.php?errorMsg=$errorMsg");
    }

//requete 3
    $sql2 = "INSERT INTO Commande (id_client, liste_id_produits_cmd, date_commande, prix) VALUES ($id_client, '$liste_prd', CURRENT_DATE(), $prix_tot)";
    $stmt2 = mysqli_prepare($connect, $sql2);
    if($stmt2->execute()){
        $sql3 = "DROP TABLE Panier_".$id_client;
        $stmt3 = mysqli_query($connect, $sql3);
        $successMsg = "Votre commande a été validée avec succès";
        header("location:consulter_panier.php?successMsg=$successMsg");
    }
    else{
        $errorMsg = mysqli_stmt_error($stmt2);
        header("location:consulter_panier.php?errorMsg=$errorMsg");
    }
}
?>
<?php
require_once 'connection.php';
require_once 'db.php';

session_start();
$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_GET['id']; // get id through query string

//Création de la table panier du client, qui se supprimera lorsque celui l'aura validé
$id_client = $_SESSION['user_login'];
$panier = "CREATE TABLE if not exists Panier_".$id_client."(
                         id_client INT UNSIGNED,
                         id_produit INT UNSIGNED,
                         quantite_produit INT,
                         date_commande DATE,
                         prix FLOAT,
                         FOREIGN KEY(id_client) REFERENCES Client(id),
                         FOREIGN KEY(id_produit) REFERENCES Produits(id))";
$res_panier = mysqli_query($connect, $panier); //Création du panier

//Début de l'ajout au panier lorsque le client clique sur "commande"
$sql1 = "SELECT stock, prix_unitaire FROM Produits WHERE id='".$id."'";
$stmt0 = mysqli_prepare($connect,$sql1);
mysqli_stmt_execute($stmt0);
$result = mysqli_stmt_get_result($stmt0);

while ($row = mysqli_fetch_assoc($result)){
    $stock = $row['stock'];
    if($_POST['quantite']>$stock){
        mysqli_close($connect); // Close connection
        $errorMsg="Veuillez entrer une quantité du produit inférieur au stock disponible";
        header("location:gestion_commande.php?errorMsg=$errorMsg"); // redirects to liste_produit page
        exit;
    }

    elseif($_POST['quantite']==0){
        mysqli_close($connect); // Close connection
        $errorMsg="Veuillez entrer une quantité du produit valide";
        header("location:gestion_commande.php?errorMsg=$errorMsg"); // redirects to liste_produit page
        exit;
    }

    elseif(empty($_POST['quantite'])){
        mysqli_close($connect); // Close connection
        $errorMsg="Veuillez entrer une quantité du produit valide";
        header("location:gestion_commande.php?errorMsg=$errorMsg"); // redirects to liste_produit page
        exit;
    }

    elseif($_POST['quantite']<0){
        mysqli_close($connect); // Close connection
        $errorMsg="Veuillez entrer une quantité du produit supérieur à 0";
        header("location:gestion_commande.php?errorMsg=$errorMsg"); // redirects to liste_produit page
        exit;
    }

    else{
        $sql2 = "SELECT id_produit, quantite_produit FROM Panier_".$id_client;
        $stmt2 = mysqli_prepare($connect, $sql2);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);

        if(mysqli_num_rows($result2)>0){
            while($row1 = mysqli_fetch_assoc($result2)){
                if($row1['id_produit']==$id){
                    $qtn = $_POST['quantite'];
                    if($qtn+$row1['quantite_produit']>$stock){
                        mysqli_close($connect); // Close connection
                        $errorMsg="Veuillez entrer une quantité du produit inférieur au stock disponible. Votre panier contient déjà ".$row1['quantite_produit']." fois cet article.";
                        header("location:gestion_commande.php?errorMsg=$errorMsg");
                        exit;
                    }
                    else{
                        $nvl_qtn = $_POST['quantite']+$row1['quantite_produit'];
                        $nouveau_prix = $nvl_qtn*$row['prix_unitaire'];
                        $sql3 = "UPDATE Panier_".$id_client." SET quantite_produit=".$nvl_qtn.", prix=".$nouveau_prix." WHERE id_produit=".$id;
                        $stmt3 = mysqli_prepare($connect, $sql3);
                        if ($stmt3->execute()) {
                            mysqli_close($connect); // Close connection
                            $successMsg = "Produit ajouté au panier avec succès";
                            header("location:gestion_commande.php?successMsg=$successMsg"); // redirects to liste_produit page
                            exit;
                        } else {
                            mysqli_close($connect); // Close connection
                            $errorMsg = mysqli_stmt_error($stmt3);
                            header("location:gestion_commande.php?errorMsg=$errorMsg"); // redirects to liste_produit page
                            exit;
                        }
                    }
                }
                else{
                    $qtn = $_POST['quantite'];
                    $id_client = $_SESSION['user_login'];
                    $prix_produit = "SELECT prix_unitaire*'{$qtn}' FROM Produits WHERE id='{$id}'";
                    $sql = "INSERT INTO Panier_".$id_client." (id_client, id_produit, quantite_produit, date_commande, prix) VALUES ($id_client, $id, $qtn, CURRENT_DATE(), ($prix_produit))";
                    $stmt = mysqli_prepare($connect, $sql);
                    if ($stmt->execute()) {
                        mysqli_close($connect); // Close connection
                        $successMsg = "Produit ajouté au panier avec succès";
                        header("location:gestion_commande.php?successMsg=$successMsg"); // redirects to liste_produit page
                        exit;
                    } else {
                        mysqli_close($connect); // Close connection
                        $errorMsg = mysqli_stmt_error($stmt);
                        header("location:gestion_commande.php?errorMsg=$errorMsg"); // redirects to liste_produit page
                        exit;
                    }
                }
            }
        }
        elseif(mysqli_num_rows($result2)==0){
            $qtn = $_POST['quantite'];
            $id_client = $_SESSION['user_login'];
            $prix_produit = "SELECT prix_unitaire*'{$qtn}' FROM Produits WHERE id='{$id}'";
            $sql = "INSERT INTO Panier_".$id_client." (id_client, id_produit, quantite_produit, date_commande, prix) VALUES ($id_client, $id, $qtn, CURRENT_DATE(), ($prix_produit))";
            $stmt = mysqli_prepare($connect, $sql);
            if ($stmt->execute()) {
                mysqli_close($connect); // Close connection
                $successMsg = "Produit ajouté au panier avec succès";
                header("location:gestion_commande.php?successMsg=$successMsg"); // redirects to liste_produit page
                exit;
            } else {
                mysqli_close($connect); // Close connection
                $errorMsg = mysqli_stmt_error($stmt);
                header("location:gestion_commande.php?errorMsg=$errorMsg"); // redirects to liste_produit page
                exit;
            }
        }
    }
}
?>
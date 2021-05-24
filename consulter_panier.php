<?php
session_start();
if(!isset($_SESSION['user_login'])) {
    header("location: index.php");
}

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_GET['id']; // get id produit
$id_client = $_SESSION['user_login'];

$errorMsg = $_GET['errorMsg'];
$successMsg = $_GET['successMsg'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="bootstrap/css/bootstrap-table.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<!-- ======== HEADER ======== -->
<div class="bg-color-sky-light">
    <header class="header">
        <div class="bg-color-sky-light">
            <nav class="navbar" role="navigation">
                <div class="container">
                    <div class="menu-container">
                        <div class="navbar-logo">
                            <img class="navbar-logo-img" src="img/logo_grey_2.png" alt="PH">
                        </div>
                    </div>
                    <div class="collapse navbar-collapse nav-collapse">
                        <div class="menu-container">
                            <ul class="navbar-nav navbar-nav-right">
                                <li class="nav-item">
                                    <a class="nav-item-child" href="gestion_client.php">Accueil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-item-child" href="gestion_commande.php">Commande</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-item-child" href="ajouter_commentaire.php">Commentaires</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-item-child" href="consulter_profil.php">Profil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-item-child active" href="consulter_panier.php">Panier</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-item-child" href="deconnexion.php">Déconnexion</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</div>
<!-- ======== FIN HEADER ======== -->

<!-- ======== PAGE ======== -->
<div class="content-md container">
    <div class="row">
        <div class="row margin-b-40">
            <div class="col-sm-12">
                <h2 align="center"> Panier </h2>
            </div>
            <?php
            if(isset($errorMsg)) {
                ?>
                <div class="alert alert-danger">
                    <strong><?php echo $errorMsg; ?></strong>
                </div>
                <?php
            }
            if(isset($successMsg)) {
                ?>
                <div class="alert alert-success">
                    <strong><?php echo $successMsg; ?></strong>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="row">
        <!-- liste des articles du panier -->
        <ul style="list-style:none">
            <?php
            $id_client = $_SESSION['user_login'];
            $sql = "SELECT P.*, Pa.quantite_produit, Pa.prix FROM Panier_".$id_client." AS Pa
                    JOIN Produits P ON P.id = Pa.id_produit
                    WHERE Pa.id_client=".$id_client;
            $stmt = mysqli_prepare($connect,$sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)){
            ?>
                <!-- 1 article du panier -->
                <li class="">
                    <div class="row">
                        <div class="col-md-4" align="left">
                            <h3> <?php echo $row['libelle'] ?> </h3>
                            <h5 class="text-info"> <?php echo $row['prix_unitaire'] ?> </h5>
                        </div>
                        <div class="col-md-4" align="center">
                            <table style="border: none; column-width: max-content">
                                <tbody>
                                <tr>
                                    <td class="text-left"><span> Ref : </span></td>
                                    <td class="text-left"><span> <?php echo $row['refe'] ?> </span></td>
                                    <td class="text-left"><span> Catégorie : </span></td>
                                    <td class="text-left"><span>  <?php echo $row['cat'] ?> </span></td>
                                </tr>
                                <tr>
                                    <td class="text-left"><span> Marque : </span></td>
                                    <td class="text-left"><span> <?php echo $row['marque'] ?> </span></td>
                                    <td class="text-left"><span> Prix : </span></td>
                                    <td class="text-left"><span> <?php echo $row['prix'] ?> </span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4" align="right">
                            <form method="POST" action="facture.php">
                                <select name="select_qtn" id="select_qtn" class="custom-select custom-select-sm" >
                                    <option selected value="<?php echo $row['quantite_produit'] ?>"><?php echo $row['quantite_produit'] ?></option>
                                    <?php
                                    $stock = (int)$row['stock'];
                                    for($a=1; $a<=$stock;$a++){
                                        echo "<option value=".$a."> ".$a." </option>";
                                    }
                                    ?>
                                </select>
                            </form>
                            <button name="supprimer" type="submit" class="btn btn-default" aria-label="Left Align" onclick="location.href='retirer_panier.php?id=<?php echo $row['id']; ?>'">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
    <!-- partie où le client doit valider le panier -->
    <div class="row" align="right">
        <button type="submit" name="valider_btn" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" onclick="location.href='facture.php'"> Valider le panier </button>
    </div>
</div>
</div>
<!-- ======== FIN PAGE ======== -->

<!-- ======== FOOTER ======== -->
<div class="bg-color-sky-light">
    <footer class="footer fixed-bottom " id="footer">
        <div class="content container">
            <div class="row">
                <div class="col-xs-6">
                    <p class="margin-b-20"> 0825 00 41 23</p>
                </div>
                <div class="col-xs-6 text-right">
                    <p class="margin-b-20"> HP Inc. 14, rue de la Verrerie – CS 40012, 92197 Meudon CEDEX France</p>
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- ======== FIN FOOTER ======== -->
</body>
</html>

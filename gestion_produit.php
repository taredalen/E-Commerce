<?php
require_once 'connection.php';

session_start();
if(!isset($_SESSION['admin_login'])) {
    header("location: index.php");
}
$id = $_SESSION['admin_login'];
//$db = mysqli_connect("localhost", "root", "", "ProjectPHP");

$select_stmt = $db->prepare("SELECT * FROM Produits WHERE id=:id");
$select_stmt->execute(array(":id"=>$id));
$row=$select_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des produits</title>
    <link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/scrollbar.css" rel="stylesheet" type="text/css"/>

</head>

<body>

<!--=========== Header ============-->
<div class="bg-color-sky-light">
    <header class="header">
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
                                <a class="nav-item-child" href="gestion_admin.php"> Accueil </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-item-child active" href="deconnexion.php">
                                    Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <h3 style="color: #19b9cc" align="center"> Administrateur
                </h3>
            </div>
        </nav>
    </header>
</div>

<!--=========== Page ============-->
<div class="section-seperator">
    <div class="content-md container">
        <div class="col well">
            <h3 class="text-primary">Gestion de produits</h3>
            <hr style="border-top:1px dotted #ccc;"/>
            <h4> Veuillez sélectionner la fonctionnalité désirée pour la gestion de produits :</h4>
            <div style="align-content: center">
                <button class="btn btn-info" name="display" onclick="location.href = 'ajouter_produit.php';">Ajouter un produit</button>
                <button class="btn btn-info" name="display" onclick="location.href = 'modifier_produit.php';">Modifier un produit</button>
                <button class="btn btn-info" name="display" onclick="location.href = 'supprimer_produit.php';">Supprimer un produit</button>
                <button class="btn btn-info" name="display" onclick="location.href = 'liste_produit.php';"">Consulter la liste des produits</button>
            </div>
        </div>
    </div>
</div>
</body>

<!--=========== FOOTER ============-->
<div class="bg-color-sky-light">
    <footer class="footer">
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
</body>
</html>


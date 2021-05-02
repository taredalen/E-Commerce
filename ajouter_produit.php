<?php
require_once 'connection.php';
require_once 'db.php';

session_start();

if(!isset($_SESSION['admin_login'])) {
    header("location: index.php");
}

if(isset($_REQUEST['btn_add'])) { //button name "btn_add"
    $refe	        = strip_tags($_REQUEST['refe']);
    $libelle		= strip_tags($_REQUEST['libelle']);
    $cat		    = strip_tags($_REQUEST['cat']);
    $marque 	    = strip_tags($_REQUEST['marque']);
    $stock	        = strip_tags($_REQUEST['stock']);
    $prix		    = strip_tags($_REQUEST['prix']);
    $tva		    = strip_tags($_REQUEST['tva']);
    $descr	        = strip_tags($_REQUEST['descr']);

    if(empty($libelle)){
        $errorMsg[]="Veuillez entrer le libellé du produit";
    }
    if(empty($stock)){
        $errorMsg[]="Veuillez entrer la quantité en stock du produit";
    }
    if(empty($prix)){
        $errorMsg[]="Veuillez entrer le prix du produit";
    }
    if(empty($tva)){
        $errorMsg[]="Veuillez entrer la TVA applicable au produit";
    }
    if(empty($descr)){
        $errorMsg[]="Veuillez entrer la description du produit";
    }

    else {
        $connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

        $sql = "INSERT INTO Produits (refe, libelle, cat, marque, stock, prix, tva, descr) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connect,$sql);
        $refe = uniqid($refe);
        mysqli_stmt_bind_param($stmt, "ssssiiis",$refe, $libelle, $cat, $marque, $stock, $prix, $tva, $descr);
        if($stmt->execute()) {
            $successMsg = "Produit ajouté avec succès";
        }
        else {
            $errorMsg[]="Erreur";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajout d'un produit</title>
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
                                <a class="nav-item-child" href="gestion_admin.php">
                                    Accueil
                                </a>
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
            <h3 class="text-primary">Ajouter un produit</h3>
            <hr style="border-top:1px dotted #ccc;"/>
            <div style="align-content: center">
                <?php
                if(isset($errorMsg)) {
                    foreach($errorMsg as $error) {
                        ?>
                        <div class="alert alert-danger">
                            <strong><?php echo $error; ?></strong>
                        </div>
                        <?php
                    }
                }
                if(isset($successMsg)) {
                    ?>
                    <div class="alert alert-success">
                        <strong><?php echo $successMsg; ?></strong>
                    </div>
                    <?php
                }
                ?>
                <form method="GET" action="ajouter_produit.php">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="refe" class="text-info"  style="color: #19b9cc">Référence produit*</label>
                            <input type="text" class="form-control" id="refe" name="refe" placeholder="..." disabled/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="libelle" class="text-info" style="color: #19b9cc">Libellé*</label>
                            <input type="text" class="form-control" id="libelle" name="libelle" minlength="3" placeholder="Ordinateur PC"/>
                            <small id="numberHelpBlock" class="form-text text-muted">
                                Doit contenir au moins 3 caractères.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="cat" class="text-info" style="color: #19b9cc">Catégorie*</label>
                            <select class="form-control" name="cat" id="cat">
                                <option value="Autre">Autre</option>
                                <option value="pc">PC</option>
                                <option value="imprimante">Imprimante</option>
                                <option value="scanner">Scanner</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="marque" class="text-info" style="color: #19b9cc">Marque*</label>
                            <select class="form-control" name="marque" id="marque">
                                <option value="Autre">Autre</option>
                                <option value="HP">HP</option>
                                <option value="cannon">Cannon</option>
                                <option value="boulanger">Boulanger</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="stock" class="text-info" style="color: #19b9cc">Quantité en stock*</label>
                            <input type="number" class="form-control" id="stock" name="stock" min="1"/>
                            <small id="numberHelpBlock" class="form-text text-muted">
                                Doit être supérieure à 0.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="prix" class="text-info" style="color: #19b9cc">Prix unitaire*</label>
                            <input type="number" class="form-control" id="prix" name="prix" placeholder="12,99"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tva" class="text-info" style="color: #19b9cc">TVA*</label>
                            <input type="number" class="form-control" id="tva" name="tva" placeholder="20"/>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="descr" class="text-info" style="color: #19b9cc">Description du produit*</label>
                            <textarea id="descr" name="descr" placeholder="..."></textarea>
                        </div>
                    </div>
                    <button type="submit" name="btn_add" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Ajouter un produit</button>
                </form>
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



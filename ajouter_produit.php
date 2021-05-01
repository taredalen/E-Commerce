<?php
require_once 'connection.php';
session_start();
if(!isset($_SESSION['admin_login'])) {
    header("location: index.php");
}
$id = $_SESSION['admin_login'];

if(isset($_REQUEST['btn_add'])) //button name "btn_add"
{
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
    if(empty($desc)){
        $errorMsg[]="Veuillez entrer la description du produit";
    }

    else {
        try {
            $connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
            $stmt = $connect->prepare("SELECT * FROM Produit WHERE refe=?");
            $stmt->bind_param("i", $refe);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

                $insert_stmt=$db->prepare("INSERT INTO Produit(refe, libelle, cat, marque, stock, prix, tva, descr)
                                      VALUES(:refe,:libelle,:cat,:marque,:stock,:prix,:tva,:descr)");		//sql insert query

                if($insert_stmt->execute(array(':refe'	=>$refe,
                    ':libelle'	=>$libelle,
                    ':cat'	    =>$cat,
                    ':marque'   =>$marque,
                    ':stock'	=>$stock,
                    ':prix'	    =>$prix,
                    ':tva'	    =>$tva,
                    ':descr'    =>$descr))){

                    $registerMsg="Le produit a été ajouté avec succès.";
                    header("refresh:4;gestion_produit.php");	//refresh 2 second after redirect to "authentification.php" page
                }

        }
        catch(PDOException $e) {
            echo $e;
            echo $e->getMessage();
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
                                <a class="nav-item-child" href="index.php">
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
<?php
    $ref = "ABCDEFGHIJKLM";
    $refe = uniqid($ref);
?>
<div class="section-seperator">
    <div class="content-md container">
        <div class="col well">
            <h3 class="text-primary">Ajouter un produit</h3>
            <hr style="border-top:1px dotted #ccc;"/>
            <div style="align-content: center">
                <form method="post" action="ajouter_produit.php">
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
                                <option value="imprimante">Imprimante</option>
                                <option value="scanner">Scanner</option>
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
                            <textarea name="message" id="descr" name="descr" placeholder="..."></textarea>
                        </div>
                    </div>
                    <button type="submit" name="btn_add" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Créer un produit</button>
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



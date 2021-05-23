<?php
require_once 'connection.php';
require_once 'db.php';

session_start();
if(!isset($_SESSION['user_login'])) {
    header("location: index.php");
}

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_SESSION['user_login'];
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
                                <a class="nav-item-child active" href="ajouter_commentaire.php">Commentaires</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-item-child" href="consulter_profil.php">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-item-child" href="consulter_panier.php">Panier</a>
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
<!--=========== Fin Header ============-->

<!--=========== Page ============-->
<div class="section-seperator">
    <div class="content-md container">
        <div class="col well">
            <h3 class="text-primary" style="color: #19b9cc" align="center">Modifier un produit</h3>
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

                $sql = "SELECT * FROM Client WHERE id='".$id."'";
                $result = mysqli_query($connect, $sql);

                while ($data = mysqli_fetch_assoc($result)){
                    ?>
                    <form method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nom" class="text-info" style="color: #19b9cc">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" minlength="3" value="<?php echo $data['nom']?>" disabled/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="prenom" class="text-info" style="color: #19b9cc">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" minlength="3" value="<?php echo $data['prenom']?>" disabled/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="mail" class="text-info" style="color: #19b9cc">Mail</label>
                                <input type="text" class="form-control" id="mail" name="mail" minlength="3" value="<?php echo $data['mail']?>" disabled/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="adresse" class="text-info" style="color: #19b9cc">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $data['rue'].' '.$data['ville'].' '.$data['code']?>" disabled/>
                            </div>
                        </div>
                    </form>
                    <?php
                }

                $sql1 = "SELECT * FROM Commande WHERE id_client='".$id."'";
                $result1 = mysqli_query($connect, $sql1);

                while ($data = mysqli_fetch_assoc($result1)){
                    ?>
                    <form method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nom" class="text-info" style="color: #19b9cc">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" minlength="3" value="<?php echo $data['nom']?>" disabled/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="prenom" class="text-info" style="color: #19b9cc">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" minlength="3" value="<?php echo $data['prenom']?>" disabled/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="mail" class="text-info" style="color: #19b9cc">Mail</label>
                                <input type="text" class="form-control" id="mail" name="mail" minlength="3" value="<?php echo $data['mail']?>" disabled/>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="adresse" class="text-info" style="color: #19b9cc">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $data['rue'].' '.$data['ville'].' '.$data['code']?>" disabled/>
                            </div>
                        </div>
                    </form>
                    <?php
                }
                ?>
                <form method="post" action="validation_facture.php?id_client=<?php echo $id?>">
                    <button type="submit" name="back" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Retour</button>
                    <button type="submit" name="valid" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Valider</button>
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
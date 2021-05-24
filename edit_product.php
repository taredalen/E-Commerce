<?php
require_once 'connection.php';
require_once 'db.php';

session_start();

if(!isset($_COOKIE['id'])) {
    header("location: index.php");
}

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$id = $_GET['id']; // get id through query string
$sql = mysqli_query($connect,"select * from Produits where id='$id'"); // select query
$row = mysqli_fetch_array($sql); // fetch data


if (isset($_POST['back'])) {
	header("Location: gestion_produit.php");
}
if(isset($_POST['update'])) {// when click on Update button
    /*$previous = array();
    array_push($previous, $_SERVER['HTTP_REFERER']);
    echo var_dump($previous);*/

    $libelle = strip_tags($_POST['libelle']);
    $cat     = strip_tags($_POST['cat']);
    $marque  = strip_tags($_POST['marque']);
    $stock   = strip_tags($_POST['stock']);
    $prix    = strip_tags($_POST['prix_unitaire']);
    $tva     = strip_tags($_POST['TVA']);
    $descr   = strip_tags($_POST['descr']);

    $result = mysqli_query($connect,"update Produits set libelle='$libelle', cat='$cat', marque='$marque', stock='$stock', prix_unitaire='$prix', tva='$tva', descr='$descr' where id='$id'");
    if($result=true) {
        $successMsg = "Produit modifié avec succès";
        //$redirects_to = end($previous);
        header("refresh:2; gestion_produit.php");
    }
    else {
        $errorMsg[]="Erreur";
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
								<a class="nav-item-child" href="gestion_admin.php">Accueil</a>
							</li>
							<li class="nav-item">
								<a class="nav-item-child active" href="gestion_produit.php">Géstion Produit</a>
							</li>
							<li class="nav-item">
								<a class="nav-item-child" href="consulter_commentaires.php">Consultation Commentaires</a>
							</li>
							<li class="nav-item">
								<a class="nav-item-child" href="deconnexion.php">Déconnexion</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</header>
</div>

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

                $sql = "SELECT * FROM Produits WHERE id='" . $id . "'";
                $result = mysqli_query($connect, $sql);

                while ($data = mysqli_fetch_assoc($result)){
                ?>

                <table class="table table-bordered table-responsive">
                    <thead class="alert-info">
                    <tr>
                        <th class="text-center">Références</th>
                        <th class="text-center">Libellé</th>
                        <th class="text-center">Catégorie</th>
                        <th class="text-center">Marque</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Prix (en €)</th>
                        <th class="text-center">TVA (en %)</th>
                        <th class="text-center">Description</th>
                    </tr>
                    </thead>
                    <tbody style="background-color:#ffffff;">
                        <tr>
                            <td class="text-center"><?php echo $data['refe']?></td>
                            <td class="text-center"><?php echo $data['libelle']?></td>
                            <td class="text-center"><?php echo $data['cat']?></td>
                            <td class="text-center"><?php echo $data['marque']?></td>
                            <td class="text-center"><?php echo $data['stock']?></td>
                            <td class="text-center"><?php echo $data['prix_unitaire']?></td>
                            <td class="text-center"><?php echo $data['TVA']?></td>
                            <td class="pt-3-half"><?php echo $data['descr']?></td>
                        </tr>
                    </tbody>
                </table>
                <br/><br/>

                <form method="POST">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="libelle" class="text-info" style="color: #19b9cc">Libellé</label>
                            <input type="text" class="form-control" id="libelle" name="libelle" minlength="3" value="<?php echo $data['libelle']?>"/>
                            <small id="numberHelpBlock" class="form-text text-muted">
                                Doit contenir au moins 3 caractères.</small>
                        </div>
	                    <div class="form-group col-md-4">
		                    <label for="cat" class="text-info" style="color: #19b9cc">Catégorie</label>
		                    <select class="form-control" name="cat" id="cat" value="<?php echo $data['cat']?>">
			                    <option value="Autre">Autre</option>
			                    <option value="pc">PC</option>
			                    <option value="imprimante">Imprimante</option>
			                    <option value="scanner">Scanner</option>
		                    </select>
	                    </div>
	                    <div class="form-group col-md-4">
		                    <label for="marque" class="text-info" style="color: #19b9cc">Marque</label>
		                    <select class="form-control" name="marque" id="marque" value="<?php echo $data['marque']?>">
			                    <option value="Autre">Autre</option>
			                    <option value="HP">HP</option>
			                    <option value="cannon">Cannon</option>
			                    <option value="boulanger">Boulanger</option>
		                    </select>
	                    </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="stock" class="text-info" style="color: #19b9cc">Quantité en stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $data['stock']?>"/>
                        </div>
	                    <div class="form-group col-md-4">
		                    <label for="prix" class="text-info" style="color: #19b9cc">Prix unitaire</label>
		                    <input type="number" class="form-control" id="prix" name="prix" value="<?php echo $data['prix_unitaire']?>"/>
	                    </div>
	                    <div class="form-group col-md-4">
		                    <label for="TVA" class="text-info" style="color: #19b9cc">TVA</label>
		                    <input type="number" class="form-control" id="TVA" name="TVA" value="<?php echo $data['TVA']?>"/>
	                    </div>
                    </div>
                    <div class="row">
	                    <div class="col-md-12 margin-b-20">
		                    <label for="descr" class="text-info" style="color: #19b9cc">Description du produit</label>
		                    <textarea class="form-control" rows="4" name="descr" id="descr" value="<?php echo $data['descr']?>"><?php echo $data['descr']?></textarea>
	                    </div>
                    </div>
	                <button type="submit" name="back" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Retourner</button>
	                <button type="submit" name="update" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Mettre à jour</button>
                </form>
                    <?php
                }
                ?>
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
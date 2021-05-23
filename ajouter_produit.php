<?php
require_once 'connection.php';
require_once 'db.php';

session_start();

if(!isset($_COOKIE['id'])) {
	header("location: index.php");
}

if(isset($_REQUEST['btn_add'])) { //button name "btn_add"
	$refe	        = strip_tags($_REQUEST['refe']);
	$libelle		= strip_tags($_REQUEST['libelle']);
	$cat		    = strip_tags($_REQUEST['cat']);
	$marque 	    = strip_tags($_REQUEST['marque']);
	$stock	        = strip_tags($_REQUEST['stock']);
	$prix		    = strip_tags($_REQUEST['prix']);
	$tva		    = strip_tags($_REQUEST['TVA']);
	$descr	        = strip_tags($_REQUEST['descr']);

	$tmpName  = $_FILES['userfile']['tmp_name'];

	$fp      = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);


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

		$sql = "INSERT INTO Produits (refe, libelle, cat, marque, stock, prix, tva, descr, content ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($connect,$sql);
		$refe = uniqid($refe);
		mysqli_stmt_bind_param($stmt, "ssssiiiss",$refe, $libelle, $cat, $marque, $stock, $prix, $tva, $descr, $content);
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
								<a class="nav-item-child " href="gestion_admin.php">Accueil</a>
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
			<div class="form-group row">
				<div class="col-xs-3">
					<button class="form-control btn-info" name="display" onclick="location.href = 'liste_produit.php';">Consulter la liste des produits</button>
				</div>
				<div class="col-xs-3">
					<button class="form-control btn-info" name="display" onclick="location.href = 'ajouter_produit.php';">Ajouter produit</button>
				</div>
				<div class="col-xs-3">
					<button class="form-control btn-info" name="display" onclick="location.href = 'modifier_produit.php';">Modifier produit</button>
				</div>
				<div class="col-xs-3">
					<button class="form-control btn-info" name="display" onclick="location.href = 'supprimer_produit.php';">Supprimer plusieurs produits</button>
				</div>
			</div>
		</div>


		<div class="col well">
			<h3 class="text-primary" style="color: #19b9cc" align="center">Ajouter un produit</h3>
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
				<form method="GET" action="ajouter_produit.php" enctype="multipart/form-data">
					<div class="row">
						<div class="form-group col-md-3">
							<label for="refe" class="text-info"  style="color: #19b9cc">Référence produit*</label>
							<input type="text" class="form-control" id="refe" name="refe" placeholder="..." disabled/>
							<small id="numberHelpBlock" class="form-text text-muted">Génerée automatiquement.</small>
						</div>
						<div class="form-group col-md-3">
							<label for="libelle" class="text-info" style="color: #19b9cc">Libellé*</label>
							<input type="text" class="form-control" id="libelle" name="libelle" minlength="3" placeholder="Ordinateur PC"/>
							<small id="numberHelpBlock" class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
						</div>
						<div class="form-group col-md-3">
							<label for="cat" class="text-info" style="color: #19b9cc">Catégorie*</label>
							<select class="form-control" name="cat" id="cat">
								<option value="Autre">Autre</option>
								<option value="pc">PC</option>
								<option value="imprimante">Imprimante</option>
								<option value="scanner">Scanner</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label for="marque" class="text-info" style="color: #19b9cc">Marque*</label>
							<select class="form-control" name="marque" id="marque">
								<option value="Autre">Autre</option>
								<option value="HP">HP</option>
								<option value="cannon">Cannon</option>
								<option value="boulanger">Boulanger</option>
							</select>
						</div>
					</div>
					<div class="row">

						<div class="form-group col-md-4">
							<label for="stock" class="text-info" style="color: #19b9cc">Quantité en stock*</label>
							<input type="number" class="form-control" id="stock" name="stock" min="1"/>
							<small id="numberHelpBlock" class="form-text text-muted">
								Doit être supérieure à 0.</small>
						</div>
						<div class="form-group col-md-4">
							<label for="prix" class="text-info" style="color: #19b9cc">Prix unitaire*</label>
							<input type="number" class="form-control" id="prix" name="prix" placeholder="12,99"/>
						</div>
						<div class="form-group col-md-4">
							<label for="TVA" class="text-info" style="color: #19b9cc">TVA*</label>
							<input type="number" class="form-control" id="TVA" name="TVA" placeholder="20"/>
						</div>
						<div class="col-md-12 margin-b-20">
							<label for="descr" class="text-info" style="color: #19b9cc">Description du produit</label>
							<textarea class="form-control" rows="4" placeholder="Description" name="descr" id="descr"></textarea>
							<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
							<input name="userfile" type="file" id="userfile">
						</div>
						<div class="form-group col-md-6">
							<button type="submit" name="btn_add" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">  Ajouter produit  </button>
						</div>
					</div>
				</form>
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
</html>



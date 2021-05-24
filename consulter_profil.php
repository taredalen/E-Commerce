<?php

require_once 'connection.php';
include 'db.php';

session_start();

if(!isset($_SESSION['user_login'])) {
	header("location: accueil.php");
}
$id = $_SESSION['user_login'];

//$select_stmt = $db->prepare("SELECT * FROM Client WHERE id=:id");
//$select_stmt->execute(array(":id"=>$id));
//$row=$select_stmt->fetch(PDO::FETCH_ASSOC);

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$stmt = $connect->prepare("SELECT * FROM Client WHERE id=?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if(isset($_SESSION['user_login'])) {
	$nom = $row['nom'];
	$prenom = $row['prenom'];
	$mail = $row['mail'];
	$rue = $row['rue'];
	$numero = $row['numero'];
	$ville = $row['ville'];
	$code = $row['code'];
	$situation = $row['situation'];
	$date = $row['naissance'];
	$sexe = $row['sexe'];
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Authentification</title>
	<link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="css/layout.min.css" rel="stylesheet" type="text/css"/>
	<link href="css/layout.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<header class="header">
	<div class="bg-color-sky-light">
	<div class="section-seperator">
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
								<a class="nav-item-child" href="gestion_client.php">Accueil </a>
							</li>
							<li class="nav-item">
								<a class="nav-item-child" href="gestion_commande.php">Commande</a>
							</li>
							<li class="nav-item">
								<a class="nav-item-child" href="ajouter_commentaire.php" >Commentaires</a>
							</li>
							<li class="nav-item">
								<a class="nav-item-child active" href="consulter_profil.php">Profil</a>
							</li>
                            <li class="nav-item">
                                <a class="nav-item-child" href="consulter_panier.php">Panier</a>
                            </li>
							<li class="nav-item">
								<a class="nav-item-child" href="deconnexion.php">Déconnexion
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</div>
	</div>
</header>

<div class="section-seperator">
	<div class="content-md container">
		<div class="row margin-b-40">
			<div class="col-sm-6">
				<h2>Votre profil</h2>

				<p><a href="modifier_profil.php"><span style="color: #19b9cc">Cliquez ici</span></a>
					si vous souhaitez modifier les informations.
				</p>
			</div>
		</div>
		<div class="row">
			<div class="container">

				<?php
				if(isset($errorMsg)) {
					foreach($errorMsg as $error) {?>
						<div class="alert alert-danger"><strong>Erreur ! <?php echo $error; ?></strong></div>
						<?php
					}
				}
				if(isset($registerMsg)) {?>
					<div class="alert alert-success"><strong><?php echo $registerMsg; ?></strong></div>
					<?php
				} ?>

				<form method="post" action="consulter_profil.php">

					<div class="row">
						<div class="form-group col-md-6">
							<label for="nom" class="text-info" style="color: #19b9cc" align="center" >Nom</label>
							<input type="text" class="form-control" id="nom" name="nom" minlength="2" placeholder='<?php echo $nom; ?>'>
						</div>
						<div class="form-group col-md-6">
							<label for="prenom" class="text-info" style="color: #19b9cc" align="center">Prenom</label>
							<input type="text" class="form-control" id="prenom" name="prenom" minlength="2" placeholder='<?php echo $prenom; ?>'>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="mail" class="text-info" style="color: #19b9cc" align="center">Email</label>
							<input type="email" class="form-control" id="mail" name="mail" placeholder='<?php echo $mail; ?>'>
						</div>
						<div class="form-group col-md-6">
							<label for="numero" class="text-info" style="color: #19b9cc" align="center">Numéro de téléphone</label>
							<input type="tel" class="form-control" id="numero" name="numero" minlength="8" placeholder='<?php echo $numero; ?>'>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="rue" class="text-info" style="color: #19b9cc" align="center">Rue</label>
							<input type="text" class="form-control" id="rue" name="rue" placeholder='<?php echo $rue; ?>'>
						</div>
						<div class="form-group col-md-4">
							<label for="ville" class="text-info" style="color: #19b9cc" align="center">Ville</label>
							<input type="text" class="form-control" id="ville" name="ville" placeholder='<?php echo $ville; ?>'>
						</div>
						<div class="form-group col-md-2">
							<label for="code" class="text-info" style="color: #19b9cc" align="center">Code Postal</label>
							<input type="text" class="form-control" id="code" name="code" minlength="5" maxlength="5" placeholder='<?php echo $code; ?>'>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="situation" class="text-info" style="color: #19b9cc" align="center">Situation Familiale </label>
							<input type="text" class="form-control" id="situation" name="situation" placeholder='<?php echo $situation; ?>'>
						</div>
						<div class="form-group col-md-4">
							<label for="naissance" class="text-info" style="color: #19b9cc" align="center">Date de naissance</label>
							<input type="date" class="form-control" id="naissance" name="naissance" placeholder='<?php echo $date; ?>'>
						</div>
						<div class="form-group col-md-2">
							<label for="sexe" class="text-info" style="color: #19b9cc" align="center">Sexe</label>
							<input type="text" class="form-control" id="sexe" name="sexe" placeholder='<?php echo $sexe; ?>'>
						</div>
					</div>
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
<!--========== END FOOTER ==========-->
</html>


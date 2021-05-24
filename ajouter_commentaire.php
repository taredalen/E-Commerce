<?php

session_start();

if(!isset($_SESSION['user_login'])) {
	header("location: accueil.php");
}

if(isset($_REQUEST['btn'])) {
	$nom		= strip_tags($_REQUEST["nom"]);
	$prenom	= strip_tags($_REQUEST["prenom"]);
	$mail	= strip_tags($_REQUEST["mail"]);
	$commentaire	= strip_tags($_REQUEST["commentaire"]);
	$reponse ="";

	if(empty($mail)){
		$errorMsg[]="Veillez entrer votre mail";
	}
	if(empty($nom)){
		$errorMsg[]="Veillez entrer votre nom";
	}
	if(empty($prenom)){
		$errorMsg[]="Veillez entrer votre prenom";
	}
	else if(empty($commentaire)){
		$errorMsg[]="Commentaire ne peut pas être vide";
	}

	else {
		try {

			$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
			$stmt = $connect->prepare("SELECT * FROM Client WHERE mail=?");
			$stmt->bind_param("s", $mail);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();

			if($mail == $row["mail"]){
				$stmt = $connect->prepare("INSERT INTO Commentaire (nom, prenom, mail, commentaire, reponse) VALUES (?, ?, ?, ?,?)");
				$stmt->bind_param("sssss",$nom, $prenom, $mail, $commentaire,$reponse);
				if($stmt->execute()) {
					$loginMsg = "Commentaire ajouté avec succès";
				}
			}
			else {
				$errorMsg[]="Mail incorrect";
			}
		} catch(Exception $e) {
		}
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Commentaires</title>
	<link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="css/layout.min.css" rel="stylesheet" type="text/css"/>
	<link href="css/layout.css" rel="stylesheet" type="text/css"/>
</head>
<body>

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

<div class="scrollbar scrollbar-primary">
	<div class="force-overflow">
		<div class="section-seperator">
			<div class="content-md container">
				<div class="margin-b-20">

					<h2>Ajouter commentaire</h2>
					<p>Veuillez remplir les champs requis pour ajouter un commentaire.
						Si vous souhaitez voir tous vos commentaires <a href="ajouter_commentaire.php"><span style="color: #19b9cc">cliquez ici</span></a>.</p>
				</div>
				<div class="row">
					<div class="col-md-5 col-sm-7">
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
						if(isset($loginMsg)) {
							?>
							<div class="alert alert-success">
								<strong><?php echo $loginMsg; ?></strong>
							</div>
							<?php
						}
						?>

						<form method="post" action="ajouter_commentaire.php">
							<div class="margin-b-20">
								<input type="text" class="form-control" placeholder="Nom" name="nom" id="nom">
							</div>
							<div class="margin-b-20">
								<input type="text" class="form-control" placeholder="Prenom" name="prenom" id="prenom">
							</div>
							<div class="margin-b-20">
								<input type="email" class="form-control" placeholder="Adresse mail" name="mail"  id="mail">
							</div>
							<div class="margin-b-20">
								<textarea class="form-control" rows="5" placeholder="Commentaire" name="commentaire" id="commentaire"></textarea>
							</div>
							<button type="submit" name="btn" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Ajouter</button>
						</form>
					</div>
					<div class="col-md-7 col-sm-7">
						<img class="img-responsive" src="img/co.png" alt="Comment Image">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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

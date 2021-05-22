<?php
session_start();
if(!isset($_SESSION['admin_login'])) {
	header("location: index.php");
}
$id = $_SESSION['admin_login'];
$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
$stmt = $connect->prepare("SELECT * FROM Administrateur WHERE id=?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
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
	<nav class="navbar" role="navigation">
		<div class="container">
			<div class="menu-container">
				<div class="navbar-logo">
					<img class="navbar-logo-img" src="img/logo_grey.png" alt="PH">
				</div>
			</div>
			<div class="collapse navbar-collapse nav-collapse">
				<div class="menu-container">
					<ul class="navbar-nav navbar-nav-right">
						<li class="nav-item">
							<a class="nav-item-child active" href="gestion_admin.php">Accueil</a>
						</li>
						<li class="nav-item">
							<a class="nav-item-child" href="gestion_produit.php">Géstion Produit</a>
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
			<h3 style="color: #19b9cc" align="center"> Administrateur
			</h3>
		</div>
	</nav>
</header>

<div class="bg-color-sky-light">
	<div class="content-md container">
		<img class="img-responsive" src="img/auth.jpg" alt="Welcome Image">
	</div>
</div>
<div class="section-seperator">
	<div class="content-md container">
		<div class="row">
			<div class="col-sm-4 sm-margin-b-50">
				<div>
					<h3>Impact durable</h3>
					<p>HP évolue vers une économie circulaire économe en matériaux et en énergie</p>
				</div>
			</div>
			<div class="col-sm-4 sm-margin-b-50">
				<div>
					<h3>Laboratoires HP</h3>
					<p>Réinventer le futur grâce à des technologies transformatrices.</p>
				</div>
			</div>
			<div class="col-sm-4">
				<div>
					<h3>Carrières</h3>
					<p>Nous nous efforçons de créer des expériences qui émerveillent, ravissent et inspirent.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="content-md container">
	<div class="row">
		<div class="col-md-7 sm-margin-b-50">
			<h2>Qui sommes-nous ?</h2>
			<p>Notre vision est de créer une technologie qui rend la vie meilleure pour tout le monde, partout - chaque personne, chaque organisation et chaque communauté à travers le monde. Cela nous motive, nous inspire à faire ce que nous faisons. À réaliser ce que nous réalisons. À inventer et à réinventer. À créer des expériences qui émerveillent. Nous n'arrêterons pas d'aller de l'avant, car vous n'arrêterez pas d'aller de l'avant. Vous réinventez votre façon de travailler. Votre façon de jouer. Votre façon de vivre. Avec notre technologie, vous réinventerez votre monde.</p>
			<p>C'est notre vocation. C’est un nouvel HP. Continuer à réinventer.</p>
		</div>
		<div class="col-sm-5 col-sm-7">
			<img class="img-responsive" src="img/desk.png" alt="Group Image">
		</div>
	</div>
</div>
<div class="bg-color-sky-light">
	<div class="content-md container">
		<div class="row margin-b-40">
			<div class="col-sm-6">
				<h2> Découvrez notre gamme de produits</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 sm-margin-b-50">
				<div class="bg-color-white margin-b-20">
					<div>
						<img class="img-responsive" src="img/1.png" alt="image 1">
					</div>
				</div>
				<h4><a href="#">PC</a> <span class="text-uppercase margin-l-20">Pro & Personnels</span></h4>
				<p>Ordinateurs portables et 2-en-1 : l’ordinateur portable adapté à chaque situation avec des performances incroyables, puissantes et un design sophistiqué.</p>
			</div>
			<div class="col-sm-4 sm-margin-b-50">
				<div class="bg-color-white margin-b-20">
					<div>
						<img class="img-responsive" src="img/2.png" alt="image 2">
					</div>
				</div>
				<h4><a href="#">Imprimantes</a> <span class="text-uppercase margin-l-20">Part & Entreprise</span></h4>
				<p>L’impression simplifiée par HP pour vous faciliter la vie : simplicité d’utilisation, connectivité et tranquillité d’esprit avec les forfaits HP Instant Ink.</p>
			</div>
			<div class="col-sm-4 sm-margin-b-50">
				<div class="bg-color-white margin-b-20">
					<div>
						<img class="img-responsive" src="img/3.png" alt="image 3">
					</div>
				</div>
				<h4><a href="#">Scanners</a> <span class="text-uppercase margin-l-20">Gamme Hp Scanjet</span></h4>
				<p>HP vous propose une gamme complète de scanners à alimentation feuille à feuille, de scanners à plat et d’expéditeurs numériques.</p>
			</div>
		</div>
	</div>
</div>
</body>
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
</html>

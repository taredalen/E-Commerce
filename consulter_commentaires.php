<!DOCTYPE html>
<html lang="en">
<head>
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
					<img class="navbar-logo-img" src="img/logo_grey_2.png" alt="PH">
				</div>
			</div>
			<div class="collapse navbar-collapse nav-collapse">
				<div class="menu-container">
					<ul class="navbar-nav navbar-nav-right">
						<li class="nav-item">
							<a class="nav-item-child active" href="gestion_admin.php">Accueil</a>
						</li>
						<li class="nav-item">
							<a class="nav-item-child">Gérer Produit</a>
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


<div class="col-md-3"></div>
<div class="col-md-6 well">
	<h3 class="text-primary">Commentaires</h3>
	<hr style="border-top:1px dotted #ccc;"/>
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<form method="POST" action="">
			<button class="btn btn-primary" name="display">Afficher les commentaires</button>
		</form>
		<br /><br />
		<table class="table table-bordered">
					<thead class="alert-info">
					<tr>
						<th>Nom</th>
						<th>Prenom</th>
						<th>Mail</th>
						<th>Commentaire</th>
					</tr>
					</thead>
					<tbody style="background-color:#fff;">

					<?php
					require_once 'connection.php';
					if(ISSET($_POST['display'])){

				$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
				$stmt = $connect->prepare("SELECT * FROM Commentaire");
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();

				while($result->fetch_assoc()){
					?>

					<tr>
						<td><?php echo $row['nom']?></td>
						<td><?php echo $row['prenom']?></td>
						<td><?php echo $row['mail']?></td>
						<td><?php echo $row['commentaire']?></td>
					</tr>
					<?php
				}
			}
					?>
					</tbody>
				</table>
	</div>
</div>





<div class="col-md-3"></div>

<div class="section-seperator">
	<div class="content-md container justify-content-center">
			<div class="col-md-8">
				<h3 class="text-primary">Commentaires</h3>
				<hr style="border-top:1px dotted #ccc;"/>
				<form method="POST" action="">
					<button class="btn btn-primary" name="display">Afficher les commentaires</button>
				</form>
				<br /><br />
				<table class="table table-bordered">
					<thead class="alert-info">
					<tr>
						<th>Nom</th>
						<th>Prenom</th>
						<th>Mail</th>
						<th>Commentaire</th>
					</tr>
					</thead>
					<tbody style="background-color:#fff;">

					<?php
					require_once 'connection.php';
					if(ISSET($_POST['display'])){

						$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
						$stmt = $connect->prepare("SELECT * FROM Commentaire");
						$stmt->execute();
						$result = $stmt->get_result();
						$row = $result->fetch_assoc();

						while($result->fetch_assoc()){
							?>

							<tr>
								<td><?php echo $row['nom']?></td>
								<td><?php echo $row['prenom']?></td>
								<td><?php echo $row['mail']?></td>
								<td><?php echo $row['commentaire']?></td>
							</tr>
							<?php
						}
					}
					?>
					</tbody>
				</table>
			</div>

	</div>
</div>
</body>


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

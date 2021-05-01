<!DOCTYPE html>
<html lang="en">
<head>
	<link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="bootstrap/css/bootstrap-table.css" rel="stylesheet" type="text/css"/>
	<link href="bootstrap/css/bootstrap-table.min.css" rel="stylesheet" type="text/css"/>
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
							<a class="nav-item-child"  href="add_comment.php">Gérer Produit</a>
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





<div class="section-seperator">
	<div class="content-md container">
		<div class="col well">
			<h3 class="text-primary">Commentaires</h3>
			<hr style="border-top:1px dotted #ccc;"/>
			<form method="POST" action="">
				<button class="btn btn-info" name="display">Afficher les commentaires</button>
			</form>
			<br /><br />
			<table class="table table-bordered table-responsive">
				<thead class="alert-info">
				<tr>
					<th class="text-center">Prenom</th>
					<th class="text-center">Nom</th>
					<th class="text-center">Mail</th>
					<th class="text-center">Commentaire</th>
					<th class="text-center col-md-1">Supprimer</th>

				</tr>
				</thead>
				<tbody style="background-color:#ffffff;">

				<?php
				require_once 'connection.php';
				if(ISSET($_POST['display'])){

					$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
					$stmt = $connect->prepare("SELECT * FROM Commentaire");
					$stmt->execute();
					$result = $stmt->get_result();

					while($row = $result->fetch_assoc()){
						?>
						<tr>
							<td class="text-center"><?php echo $row['prenom']?></td>
							<td class="text-center"><?php echo $row['nom']?>  </td>
							<td class="text-center"><?php echo $row['mail']?></td>
							<td class="pt-3-half " contenteditable="true"><?php echo $row['commentaire']?></td>
							<th class="text-center col-md-1">
								<button type="submit" name="supprimer" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">supprimer</button>
							</th>

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

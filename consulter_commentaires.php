<!DOCTYPE html>
<html lang="en">
<head>
	<link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="bootstrap/css/bootstrap-table.css" rel="stylesheet" type="text/css"/>
	<link href="css/layout.min.css" rel="stylesheet" type="text/css"/>
	<link href="css/layout.css" rel="stylesheet" type="text/css"/>

</head>
<body>

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
							<a class="nav-item-child"  href="gestion_produit.php">Gérer Produit</a>
						</li>
						<li class="nav-item">
							<a class="nav-item-child active" href="consulter_commentaires.php">Consultation Commentaires</a>
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
<div class="section-seperator">
	<div class="content-md container">
		<div class="col well">
			<div class="form-group row">
				<form method="POST" action="">
				<div class="col-xs-6">
					<input class="form-control" style="background-color:#ffffff;" id="mail" type="text" name="mail">
				</div>
				<div class="col-xs-3">
					<button class="form-control btn-info" name="display_one">Effectuer la recherche</button>
				</div>
				</form>
				<div class="col-xs-3">
					<form method="POST" action="">
						<button class="form-control btn-info" name="display_all">Afficher tous les commentaires</button>
					</form>
				</div>
			</div>
			<hr style="border-top:1px dotted #ccc;"/>
			<?php
			if(isset($_GET["message"])){
				$message = $_GET["message"];
				?>
				<div class="alert alert-success" align="center">
					<strong><?php echo $message; ?></strong>
				</div>
				<?php
				if(isset($_GET["param"])=='all'){
					header("refresh:2; consulter_commentaires.php");
				}
				else if(isset($_GET["param"])=='one'){
					$param = 'one';
				}
			}
			?>

			<table class="table table-bordered ">
				<thead class="alert-info">
				<tr>
					<th class="text-center col-sm-1">Prenom</th>
					<th class="text-center col-sm-1">Nom</th>
					<th class="text-center">Mail</th>
					<th class="text-center">Commentaire</th>
					<th class="text-center">Réponse</th>

				</tr>
				</thead>
				<tbody style="background-color:#ffffff;">

				<?php
				$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

				if(ISSET($_POST['display_all']) OR isset($_GET["message"])){

					$stmt = $connect->prepare("SELECT * FROM Commentaire");
					$stmt->execute();
					$result = $stmt->get_result();

					while($row = $result->fetch_assoc()){
						?>
						<tr>
							<td class="text-center"><?php echo $row['prenom']?></td>
							<td class="text-center"><?php echo $row['nom']?>  </td>
							<td class="text-center"><?php echo $row['mail']?></td>
							<td class="pt-3-half "><?php echo $row['commentaire']?></td>
							<th class="text-center" contenteditable="true"></th>
							<td>
								<a href=ajouter_reponse.php?id=<?php echo $row["id"]?>&param=all><button class="btn btn-info">✓</button></a>
								<a href=suppression.php?id=<?php echo $row["id"]?>&param=all><button class="btn btn-info">✕</button></a>
							</td>
						</tr>
						<?php
					}
				}

				if(ISSET($_POST['display_one'])){
					$mail = strip_tags($_REQUEST["mail"]);

					$stmt = $connect->prepare("SELECT * FROM Commentaire WHERE mail=?");
					$stmt->bind_param("s", $mail);
					$stmt->execute();
					$result = $stmt->get_result();
					while($row = $result->fetch_assoc()){
						?>
						<tr>
							<td class="text-center"><?php echo $row['prenom']?></td>
							<td class="text-center"><?php echo $row['nom']?>  </td>
							<td class="text-center"><?php echo $row['mail']?></td>
							<td class="pt-3-half "><?php echo $row['commentaire']?></td>
							<th class="text-center" contenteditable="true"></th>
							<td>
								<a href=ajouter_reponse.php?id=<?php echo $row["id"]?>&param=one><button class="btn btn-info">✓</button></a>
								<a href=suppression.php?id=<?php echo $row["id"]?>&param=one> <button class="btn btn-info">✕</button></a>
							</td>
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

<div class="bg-color-sky-light">
	<footer class="footer" id="footer">
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

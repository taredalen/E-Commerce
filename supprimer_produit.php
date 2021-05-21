<?php
require_once 'connection.php';
require_once 'db.php';

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
if(isset($_POST['supprimer'])){
	$checkbox = $_POST['check'];
	if(empty($checkbox)){
		$errorMsg[] ="Il n'y a aucun produits";
	}
	else{
		for($i=0;$i<count($checkbox);$i++){
			$del_id = $checkbox[$i];
			$sql = "SELECT stock FROM Produits WHERE id='".$del_id."'";
			$result = mysqli_query($connect, $sql);
			if (mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					if($row["stock"]>0){
						$errorMsg[] ="Le stock de ce produit n'est pas nul. Il ne peut dont pas être supprimé.";
					}
					else{
						$result = mysqli_query($connect,"DELETE FROM Produits WHERE id='".$del_id."'");
						if($result=true) {
							$successMsg = "Produits supprimés avec succès";
						}
						else {
							$errorMsg[]="Erreur";
						}
					}
				}
			}
		}
	}
}
?>

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


<div class="bg-color-sky-light">
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
			<h3 class="text-primary" style="color: #19b9cc" align="center">Supprimer les produits</h3>
			<hr style="border-top:1px dotted #ccc;"/>
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
			<form method="POST" action="">
				<button type="submit" name="supprimer" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Supprimer</button>
				<br/><br/>

				<table class="table table-bordered table-responsive">
					<thead class="alert-info">
					<tr>
						<th class="text-center"></th>
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

					<?php
					require_once 'connection.php';
					$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

					$sql = "SELECT * FROM Produits";
					$stmt = mysqli_prepare($connect,$sql);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);

					$i=0;
					while($row = mysqli_fetch_assoc($result)){
						?>
						<tr>
							<td class="text-center">
								<input class="text-center" type="checkbox" name="check[]" value="<?php echo $row["id"]; ?>">
							</td>
							<td class="text-center"><?php echo $row['refe']?></td>
							<td class="text-center"><?php echo $row['libelle']?>  </td>
							<td class="text-center"><?php echo $row['cat']?></td>
							<td class="text-center"><?php echo $row['marque']?></td>
							<td class="text-center"><?php echo $row['stock']?></td>
							<td class="text-center"><?php echo $row['prix']?></td>
							<td class="text-center"><?php echo $row['TVA']?></td>
							<td class="pt-3-half"><?php echo $row['descr']?></td>
						</tr>
						<?php
					}
					$i++;
					?>
					</tbody>
				</table>
			</form>
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
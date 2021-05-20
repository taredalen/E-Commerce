<?php
require_once 'connection.php';
require_once 'db.php';

$errorMsg = $_GET['errorMsg'];
$successMsg = $_GET['successMsg'];
?>

<div class="col well">
	<h3 class="text-primary" style="color: #19b9cc" align="center">Consulter la liste des produits</h3>
	<hr style="border-top:1px dotted #ccc;"/>

	<div class="form-group row">
		<form method="POST" action="">
			<div class="col-xs-4">
				<label for="cat" class="text-info"  style="color: #19b9cc">Catégorie</label>
				<select class="form-control" name="cat" id="cat">
					<option value="Tout">Tout</option>
					<option value="Autre">Autre</option>
					<option value="pc">PC</option>
					<option value="imprimante">Imprimante</option>
					<option value="scanner">Scanner</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="marque" class="text-info"  style="color: #19b9cc">Marque</label>
				<select class="form-control" name="marque" id="marque">
					<option value="Tout">Tout</option>
					<option value="Autre">Autre</option>
					<option value="HP">HP</option>
					<option value="cannon">Cannon</option>
					<option value="boulanger">Boulanger</option>
				</select>
			</div>
			<div class="col-xs-4">
				<label for="marque" class="text-info"  style="color: #19b9cc">Recherche </label>
				<button  type="submit" class="form-control btn-info" name="recherche">Consulter la liste des produits</button>
			</div>
		</form>
	</div>
	<hr style="border-top:1px dotted #ccc;"/>
	<br/><br/>

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
			<th class="text-center col-md-1">Modifier</th>
			<th class="text-center col-md-1">Supprimer</th>
		</tr>
		</thead>
		<tbody style="background-color:#ffffff;">

		<?php
		require_once 'connection.php';
		$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

		if(ISSET($_POST['recherche'])){
			echo "dfcvd";
			$categorie = $_POST['cat'];
			$marque = $_POST['marque'];
			if($categorie!='Tout' && $marque!='Tout'){
				$sql = "SELECT * FROM Produits WHERE cat='{$categorie}' AND marque='{$marque}'";
			}
			elseif($categorie!='Tout' && $marque='Tout'){
				$sql = "SELECT * FROM Produits WHERE cat='{$categorie}'";
			}
			elseif($categorie='Tout' && $marque!='Tout'){
				$sql = "SELECT * FROM Produits WHERE marque='{$marque}'";
			}
			elseif($categorie='Tout' && $marque='Tout'){
				$sql = "SELECT * FROM Produits";
			}
		}
		else{
			$sql = "SELECT * FROM Produits";
		}

		$stmt = mysqli_prepare($connect,$sql);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);

		$i=0;
		while($row = mysqli_fetch_assoc($result)){
			?>
			<tr>
				<td class="text-center"><?php echo $row['refe']?></td>
				<td class="text-center"><?php echo $row['libelle']?>  </td>
				<td class="text-center"><?php echo $row['cat']?></td>
				<td class="text-center"><?php echo $row['marque']?></td>
				<td class="text-center"><?php echo $row['stock']?></td>
				<td class="text-center"><?php echo $row['prix']?></td>
				<td class="text-center"><?php echo $row['TVA']?></td>
				<td class="pt-3-half"><?php echo $row['descr']?></td>
				<th class="text-center col-md-1">
					<button type="submit" name="modifier" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" onclick="location.href='edit_product.php?id=<?php echo $row['id']; ?>'">Modifier</button>
				</th>
				<th class="text-center col-md-1">
					<button type="submit" name="supprimer" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" onclick="location.href='delete_product.php?id=<?php echo $row['id']; ?>'">Supprimer</button>
				</th>
			</tr>
			<?php
		}
		$i++;
		?>
		</tbody>
	</table>
	<?php
		//header("refresh:3; consulter_commentaires.php");

		?>
</div>

<?php
require_once "connection.php";
require_once "db.php";

session_start();
if(!isset($_SESSION['admin_login'])) {
    header("location: index.php");
}

$id = $_SESSION['admin_login'];

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

?>

<div class="col well">
	<h3 class="text-primary" style="color: #19b9cc" align="center">Modifier un produit</h3>
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
						<input type='hidden' name='id' value="<?php echo $row["id"]?>"/>
						<input class="text-center" type="radio" name="round" onclick="location.href='edit_product.php?id=<?php echo $row['id']; ?>'">
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




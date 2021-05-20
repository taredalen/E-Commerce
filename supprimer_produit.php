<?php
require_once 'connection.php';
require_once  'db.php';

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
                            $successMsg = "Produit(s) supprimé(s) avec succès";
                            header("location:supprimer_produit.php?successMsg=$successMsg");
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

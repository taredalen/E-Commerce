<?php
function connexion(){

	$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
	if($connect) return $connect;
	else return null;
}
?>


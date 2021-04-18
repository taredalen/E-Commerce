<?php

require_once "connection.php";
require_once "db.php";

session_start();
if(!isset($_SESSION['user_login'])) {
	header("location: index.php");
}

$id = $_SESSION['user_login'];
$select_stmt = $db->prepare("SELECT * FROM Client WHERE id=:id");
$select_stmt->execute(array(":id"=>$id));
$row=$select_stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_SESSION['user_login'])) {
	$nom = $row['nom'];
	$prenom = $row['prenom'];
	$mail = $row['mail'];
	$rue = $row['rue'];
	$numero = $row['numero'];
	$ville = $row['ville'];
	$code = $row['code'];
	$situation = $row['situation'];
	$naissance = $row['naissance'];
	$sexe = $row['sexe'];
	$password = $row['password'];
}

$date = Datetime::createFromFormat('Y-m-d', $naissance);
$date_format=$date->format('d-m-Y');

if(isset($_POST['btn_save1'])){
	$nom	    = strip_tags($_POST['nom']);
	$prenom		= strip_tags($_POST['prenom']);
	$mail		= strip_tags($_POST['mail']);
	$numero 	= strip_tags($_POST['numero']);
	$rue	    = strip_tags($_POST['rue']);
	$ville		= strip_tags($_POST['ville']);
	$code		= strip_tags($_POST['code']);

	$date = Datetime::createFromFormat('d-m-Y', $naissance);

	if(empty($nom)){
		$errorMsg[]="Veuillez entrer votre nom";
	}
	if(empty($prenom)){
		$errorMsg[]="Veuillez entrer votre prenom";
	}
	if(empty($rue)){
		$errorMsg[]="Veuillez entrer votre rue";
	}
	if(empty($code)){
		$errorMsg[]="Veuillez entrer votre code postal";
	}
	if(empty($situation)){
		$errorMsg[]="Veuillez choisir votre situation";
	}
	if(empty($sexe)){
		$errorMsg[]="Veuillez choisir votre sexe";
	}
	if(empty($situation)){
		$errorMsg[]="Veuillez entrer votre mot de passe";
	}
	else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
		$errorMsg[]="Email format est incorrect!";
	}
	else if(!preg_match("/^0[0-9]{7}$/", $numero) ) {
		$errorMsg[]="Format de numéro de téléphone est incorrect!";
	}
	else if(!preg_match("/^[0-9]{5}$/", $code) ) {
		$errorMsg[]="Format de code postal est incorrect!";
	}
	else if(! $date) {
		$errorMsg[]="Format de date incorrect";
	}

	else {
		try {
			if(!isset($errorMsg)) {
				$date_format=$date->format('Y-m-d');
				$new_password = password_hash($password, PASSWORD_DEFAULT); //encrypt password using password_hash()

				$insert_stmt=$db->prepare("INSERT INTO Client(nom, prenom, mail, numero, rue, ville, code, situation, naissance, sexe, password)
                                      VALUES(:nom,:prenom,:mail,:numero,:rue,:ville,:code,:situation,:naissance,:sexe,:password)");		//sql insert query

				if($insert_stmt->execute(array(':nom'	=>$nom,
					':prenom'	=>$prenom,
					':mail'	    =>$mail,
					':numero'   =>$numero,
					':rue'	    =>$rue,
					':ville'	=>$ville,
					':code'	    =>$code,
					':situation'=>$situation,
					':naissance'=>$date_format,
					':sexe' 	=>$sexe,
					':password' =>$new_password))){

					$registerMsg="Les informations de profil modifiées avec succès.";
				}
			}
		}
		catch(PDOException $e) {
			echo $e;
			echo $e->getMessage();
		}
	}
}

if(isset($_POST['btn_save2']))
{
	$situation	= strip_tags($_POST['situation']);
	$naissance	= strip_tags($_POST['naissance']);
	$sexe		= strip_tags($_POST['sexe']);

	try {
		if(!isset($errorMsg3)) {
			$date = Datetime::createFromFormat('Y-m-d', $naissance);
			$date_format=$date->format('d-m-Y');

			$insert_stmt=$db->prepare("UPDATE Client SET situation=:situation,naissance=:naissance,sexe=:sexe WHERE  id=:id");//sql insert query

			if($insert_stmt->execute(array(':situation' =>$situation, ':naissance' =>$date_format, ':sexe' =>$sexe))){
				$registerMsg3="Les informations sont modifiées avec succès";
			}
		}
	}
	catch(PDOException $e) {}
}

if(isset($_POST['btn_save3']))
{
	echo '2';
	$old_password	= strip_tags($_POST['old_password']);
	$new_password	= strip_tags($_POST['new_password']);
	$password	    = strip_tags($_POST['password']);

	if(strlen($password) < 8){
		$errorMsg3[] = "Mot de passe doit contenir au moins 8 caractères";
	}
	else if(!preg_match("/^[A-Z][a-zA-Z0-9]*[a-z]$/", $password)){
		$errorMsg3[] = "Format de mot de passe est incorrect!";
	}
	else if($new_password != $password){
		$errorMsg3[] = "Confirmation du mot de passe a échoué. Verifiez que vous avez entré le même mot de passe!";
	}

	else {
		try {
			if(!isset($errorMsg3)) {

				//$new_password = password_hash($password, PASSWORD_DEFAULT); //encrypt password using password_hash()

				$insert_stmt=$db->prepare("UPDATE Client SET password = :password WHERE  id=:id");//sql insert query

				if($insert_stmt->execute(array(':password' 	=>$password, ":id" =>$id))){
					$registerMsg3="Le mot de passe modifié avec succès";
				}
			}
		}
		catch(PDOException $e) {}
	}
}
?>


<!--=========== HTML ============-->
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
<!-------------- HEADER -------------->
<header class="header">
	<div class="bg-color-sky-light">
		<div class="section-seperator">
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
									<a class="nav-item-child" href="gestion_client.php">Accueil </a>
								</li>
								<li class="nav-item">
									<a class="nav-item-child">Commande</a>
								</li>
								<li class="nav-item">
									<a class="nav-item-child">Commentaires</a>
								</li>
								<li class="nav-item">
									<a class="nav-item-child active" href="consulter_profil.php">Profil</a>
								</li>
								<li class="nav-item">
									<a class="nav-item-child" href="deconnexion.php">Déconnexion
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</nav>
		</div>
	</div>
</header>
<!------------ END HEADER ------------>

<!---------- INFO GENERALES ---------->
<div class="section-seperator">
	<div class="content-md container">
		<div class="row margin-b-40">
			<div class="col-sm-6">
				<h2>Informations générales</h2>
				<p>Veuillez saisir les informations que vous souhaitez changer dans les champs.</p>
			</div>
		</div>
		<div class="row">
			<div class="container">
				<?php
				if(isset($errorMsg)) {
					foreach($errorMsg as $error) {
						?>
						<div class="alert alert-danger">
							<strong>Erreur ! <?php echo $error; ?></strong>
						</div>
						<?php
					}
				}
				if(isset($registerMsg)) {
					?>
					<div class="alert alert-success">
						<strong><?php echo $registerMsg; ?></strong>
					</div>
					<?php
				}
				?>

				<form method="post"  action="modifier_profil.php">
					<div class="row">
						<div class="form-group col-md-6">
							<label for="nom" class="text-info"  style="color: #19b9cc">Nom</label>
							<input type="text" class="form-control" id="nom" name="nom" minlength="2" value='<?php echo $nom; ?>'>
						</div>
						<div class="form-group col-md-6">
							<label for="prenom" class="text-info" style="color: #19b9cc">Prenom</label>
							<input type="text" class="form-control" id="prenom" name="prenom" minlength="2" value='<?php echo $prenom; ?>'>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="mail" class="text-info" style="color: #19b9cc">Email</label>
							<input type="email" class="form-control" id="mail" name="mail" value='<?php echo $mail; ?>'>
						</div>
						<div class="form-group col-md-6">
							<label for="numero" class="text-info" style="color: #19b9cc">Numéro de téléphone</label>
							<input type="tel" class="form-control" id="numero" name="numero" minlength="8" value='<?php echo $numero; ?>'>
							<small id="numberHelpBlock" class="form-text text-muted">
								Doit contenir 8 chiffres et commencer par 0</small>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="rue" class="text-info" style="color: #19b9cc">Rue</label>
							<input type="text" class="form-control" id="rue" name="rue" value='<?php echo $rue; ?>'>
						</div>
						<div class="form-group col-md-4">
							<label for="ville" class="text-info" style="color: #19b9cc">Ville</label>
							<input type="text" class="form-control" id="ville" name="ville" value='<?php echo $ville; ?>'>
						</div>
						<div class="form-group col-md-2">
							<label for="code" class="text-info" style="color: #19b9cc">Code Postal</label>
							<input type="text" class="form-control" id="code" name="code" minlength="5" maxlength="5" value='<?php echo $code; ?>'>
						</div>
					</div>
					<button type="submit" name="btn_save1" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Enregistrer</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!--====== FIN INFO GENERALES ======-->

<!---------- INFO COMPLEMT ------------>
<div class="section-seperator">
	<div class="content-md container">
		<div class="row margin-b-40">
			<div class="col-sm-6">
				<h2>Informations complémentaires</h2>
				<p>Ces données ne sont pas obligatoires, mais vous pouvez les modifier si vous le souhaitez.</p>
			</div>
		</div>
		<div class="row">
			<div class="container">
				<?php
				if(isset($errorMsg2)) {
					foreach($errorMsg2 as $error) {
						?>
						<div class="alert alert-danger">
							<strong>Erreur ! <?php echo $error; ?></strong>
						</div>
						<?php
					}
				}
				if(isset($registerMsg2)) {
					?>
					<div class="alert alert-success">
						<strong><?php echo $registerMsg2; ?></strong>
					</div>
					<?php
				}
				?>
				<form method="post" action="modifier_profil.php">
					<div class="row">
						<div class="form-group col-md-6">
							<label for="naissance" class="text-info" style="color: #19b9cc">Date de naissance</label>
							<input type="date" class="form-control" id="naissance" name="naissance" value='<?php echo $date_format; ?>'>
							<small id="passwordHelpBlock" class="form-text text-muted">
								Sous format JJ-MM-AAAA
							</small>
						</div>
						<div class="form-group col-md-4">
							<label for="situation" class="text-info" style="color: #19b9cc">Situation Familiale </label>
							<select class="form-control" name="situation" id="situation">
								<option value= <?php echo $situation; ?>><?php echo $situation; ?></option>
								<option value="Célibataire">Célibataire</option>
								<option value="Marié(e)">Marié(e)</option>
								<option value="Pacsé(e)" >Pacsé(e)</option>
								<option value="Divorcé(e)">Divorcé(e)</option>
								<option value="Séparé(e)">Séparé(e)</option>
								<option value="Veuf(ve)">Veuf(ve)</option>
								<option value="Autre">Autre</option>
							</select>
						</div>
						<div class="form-group col-md-2">
							<label for="sexe" class="text-info" style="color: #19b9cc">Sexe</label>
							<select class="form-control" name="sexe" id="sexe">
								<option value="<?php echo $sexe; ?>"><?php echo $sexe; ?></option>
								<option value="Autre">Autre</option>
								<option value="Homme">Homme</option>
								<option value="Femme">Femme</option>
							</select>
						</div>
					</div>
					<button type="submit" name="btn_save2" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Enregistrer</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-------- FIN INFO COMPLEMT ---------->

<!---------- MOT DE PASSE ------------>
<div class="section-seperator">
	<div class="content-md container">
		<div class="row margin-b-40">
			<div class="col-sm-6">
				<h2>Mot de passe</h2>
				<p>	Votre mot de passe doit contenir au moins 8 caractères, commencer par une lettre majuscule et se terminer par un lettre minuscule, sans caractères spéciaux. .</p>
			</div>
		</div>
		<div class="row">
			<div class="container">
				<?php
				if(isset($errorMsg3)) {
					foreach($errorMsg3 as $error) {
						?>
						<div class="alert alert-danger">
							<strong>Erreur ! <?php echo $error; ?></strong>
						</div>
						<?php
					}
				}
				if(isset($registerMsg3)) {
					?>
					<div class="alert alert-success">
						<strong><?php echo $registerMsg3; ?></strong>
					</div>
					<?php
				}
				?>
				<form method="post" action="modifier_profil.php">
					<div class="row">
						<div class="form-group col-md-4">
							<label for="password" class="text-info" style="color: #19b9cc">Ancien mot de Passe</label>
							<input type="password" class="form-control" id="password" name="old_password" minlength="8" aria-describedby="passwordHelpBlock">
						</div>
						<div class="form-group col-md-4">
							<label for="password2" class="text-info" style="color: #19b9cc">Nouveau mot de passe</label>
							<input type="password" class="form-control" id="password2" name="new_password">
						</div>
						<div class="form-group col-md-4">
							<label for="password2" class="text-info" style="color: #19b9cc">Confirmation</label>
							<input type="password" class="form-control" id="password2" name="password">
						</div>
					</div>
					<button type="submit" name="btn_save3" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Enregistrer</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-------- FIN MOT DE PASSE ---------->

<!------------- FOOTER --------------->
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
<!--========== END FOOTER ==========-->
</body>
</html>


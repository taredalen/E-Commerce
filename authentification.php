<?php
session_start();

if(isset($_SESSION["user_login"])){
	header("location: gestion_client.php");
}

if(isset($_REQUEST['btn_login'])) {
	$mail		= strip_tags($_REQUEST["mail"]);
	$password	= strip_tags($_REQUEST["password"]);
	$profile	= strip_tags($_REQUEST["profile"]);

	if(empty($mail)){
		$errorMsg[]="Veillez entrer votre mail";
	}
	else if(empty($password)){
		$errorMsg[]="Veillez entrer votre mot de passe";
	}
	else if(!($profile)){
		$errorMsg[]="Selectionner le profil";
	}
	else {
		try {
			if($profile == 'client') {
				//$select_stmt = $db->prepare("SELECT * FROM Client WHERE mail=:mail"); //sql select query
				//$select_stmt->execute(array(':mail' => $mail));    //execute query with bind parameter
				//$row = $select_stmt->fetch(PDO::FETCH_ASSOC);

				$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
				$stmt = $connect->prepare("SELECT * FROM Client WHERE mail=?");
				$stmt->bind_param("s", $mail);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();

				if ($row) {
					if ($mail == $row["mail"]) {
						if (password_verify($password, $row["password"])) {
							$_SESSION["user_login"] = $row["id"];    //session name is "user_login"
							$_SESSION["prenom"] = $row["prenom"];
							$loginMsg = "Connexion réussie...";        //user login success message
							header("refresh:2; gestion_client.php");
						} else {
							$errorMsg[] = "Votre mot de passe est incorrect ";
						}
					} else {
						$errorMsg[] = "Login incorrect";
					}
				} else {
					$errorMsg[] = "Aucun compte associé à ce login";
				}
			}

			if($profile == 'admin') {
				//$select_stmt = $db->prepare("SELECT * FROM Administrateur WHERE mail=:mail"); //sql select query
				//$select_stmt->execute(array(':mail' => $mail));    //execute query with bind parameter
				//$row = $select_stmt->fetch(PDO::FETCH_ASSOC);

                $connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
				$stmt = $connect->prepare("SELECT * FROM Administrateur WHERE mail=?");
				$stmt->bind_param("s", $mail);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();

				if ($row) {
					if ($mail == $row["mail"]) {
						if ($password == $row["password"]) {
							$_SESSION["admin_login"] = $row["id"];    //session name is "admin_login"
							$_SESSION["prenom"] = $row["prenom"];
							setcookie('id', $row["id"], time()+ 3600 * 24 * 5);
							$loginMsg = "Connexion réussie...";        //admin login success message
							header("refresh:2; gestion_admin.php");
						} else {
							$errorMsg[] = "Votre mot de passe est incorrect ";
						}
					} else {
						$errorMsg[] = "Login incorrect";
					}
				} else {
					$errorMsg[] = "Aucun compte associé à ce login";
				}
			}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Authentification</title>
	<link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="css/layout.min.css" rel="stylesheet" type="text/css"/>
	<link href="css/scrollbar.css" rel="stylesheet" type="text/css"/>

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
								<a class="nav-item-child" href="accueil.php">
									Accueil
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-item-child active" href="authentification.php">
									Authentification
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
	</header>
</div>


<div class="scrollbar scrollbar-primary">
	<div class="force-overflow">
		<div class="section-seperator">
			<div class="content-md container">
				<div class="row">
					<div class="col-md-7 col-sm-7">
						<img class="img-responsive" src="img/desk.png" alt="Welcome Image">
					</div>
					<div class="col-md-5 col-sm-7">
						<h2>Authentification</h2>
						<p>Veuillez vous connecter pour accéder aux fonctionnalités du site.
							Si vous n'avez pas de compte <a href="inscription.php"><span style="color: #19b9cc">cliquez ici</span></a>
							pour effectuer l'inscription.
						</p>
						<?php
						if(isset($errorMsg))
						{
							foreach($errorMsg as $error)
							{
								?>
								<div class="alert alert-danger">
									<strong><?php echo $error; ?></strong>
								</div>
								<?php
							}
						}
						if(isset($loginMsg))
						{
							?>
							<div class="alert alert-success">
								<strong><?php echo $loginMsg; ?></strong>
							</div>
							<?php
						}
						?>

						<form method="post" action="authentification.php">

							<div class="margin-b-20">
								<input class="form-check-input" type="radio" name="profile" id="inlineRadio1" value="admin">
								<label class="form-check-label" for="admin" style="color: #19b9cc;  margin-right: 50px">admin</label>

								<input class="form-check-input" type="radio" name="profile" id="inlineRadio2" value="client">
								<label class="form-check-label" for="client" style="color: #19b9cc">client</label>

							</div>
							<div class="margin-b-20">
								<input type="text" class="form-control" placeholder="Login (adresse mail)" name="mail">
							</div>
							<div class="margin-b-20">
								<input type="password" class="form-control" placeholder="Mot de passe" name="password">
							</div>
							<button type="submit" name="btn_login" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Connection</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--=========== FOOTER ============-->
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
</body>
</html>
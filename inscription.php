<?php

require_once "connection.php";
require_once "db.php";

if(isset($_REQUEST['btn_register'])) //button name "btn_register"
{
    $nom	    = strip_tags($_REQUEST['nom']);
    $prenom		= strip_tags($_REQUEST['prenom']);
    $mail		= strip_tags($_REQUEST['mail']);
    $numero 	= strip_tags($_REQUEST['numero']);
    $rue	    = strip_tags($_REQUEST['rue']);
    $ville		= strip_tags($_REQUEST['ville']);
    $code		= strip_tags($_REQUEST['code']);
    $situation	= strip_tags($_REQUEST['situation']);
    $naissance	= strip_tags($_REQUEST['naissance']);
    $sexe		= strip_tags($_REQUEST['sexe']);
    $password	= strip_tags($_REQUEST['password']);
    $password2	= strip_tags($_REQUEST['password2']);

    if(empty($nom)){
        $errorMsg[]="Veuillez entrer votre nom";
    }
    if(empty($prenom)){
        $errorMsg[]="Veuillez entrer votre prénom";
    }
    if(empty($rue)){
        $errorMsg[]="Veuillez entrer votre rue";
    }
    if(empty($code)){
        $errorMsg[]="Veuillez entrer votre code postal";
    }
    else if(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
        $errorMsg[]="le format de l'Email est incorrect!";
    }
    else if(!preg_match("/^0[0-9]{7}$/", $numero) ) {
        $errorMsg[]="Le format du numéro de téléphone est incorrect!";
    }
    else if(!preg_match("/^[0-9]{5}$/", $code) ) {
        $errorMsg[]="Le format du code postal est incorrect!";
    }
    else if(strlen($password) < 8){
        $errorMsg[] = "Le mot de passe doit contenir au moins 8 caractères";
    }
    else if(!preg_match("/^[A-Z][a-zA-Z0-9]*[a-z]$/", $password)){
        $errorMsg[] = "Le format du mot de passe est incorrect!";
    }
    else if($password2 != $password){
        $errorMsg[] = "La confirmation du mot de passe a échoué. Verifiez que vous avez entré le même mot de passe!";
    }

    else {
        try {
            $select_stmt=$db->prepare("SELECT mail FROM Client WHERE mail=:mail");

            $select_stmt->execute(array(':mail'=>$mail)); //execute query
            $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

            if($row["mail"]==$mail){
                $errorMsg[]="Le compte relié avec cet adresse mail existe déjà";
            }
            else if(!isset($errorMsg)) {

	            if(empty($naissance)) {
		            $date_format = NULL;
	            }
	            if(!empty($naissance)) {
		            $date = Datetime::createFromFormat('DD-MM-YYYY', $naissance);
		            $date_format=$date->format('YYYY-MM-DD');
	            }
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

                    $registerMsg="Le profil a été enregistré avec succès. Ne quittez pas, vous serez redirigé vers la page d'authentification.";
                    header("refresh:4;authentification.php");	//refresh 2 second after redirect to "authentification.php" page
                }
            }
        }
        catch(PDOException $e) {
            echo $e;
            echo $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="http://fonts.googleapis.com/css?family=Hind:300,400,500,600,700" rel="stylesheet" type="text/css">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.min.css" rel="stylesheet" type="text/css"/>
    <link href="css/layout.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<!--=========== HEADER ============-->
<div class="bg-color-sky-light">
    <div class="section-seperator">
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
                                    <a class="nav-item-child" href="authentification.php">
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
</div>
<!--========== END HEADER ==========-->

<div class="section-seperator">
    <div class="content-md container">
        <div class="row margin-b-40">
            <div class="col-sm-6">
                <h2>Inscription</h2>
                <p>Veuillez saisir les informations démandées dans les champs.</p>
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

                <form method="post" action="inscription.php">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nom" class="text-info"  style="color: #19b9cc">Nom*</label>
                            <input type="text" class="form-control" id="nom" name="nom" minlength="2" placeholder="Hewlett">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="prenom" class="text-info" style="color: #19b9cc">Prenom*</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" minlength="2" placeholder="William">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="mail" class="text-info" style="color: #19b9cc">Email*</label>
                            <input type="email" class="form-control" id="mail" name="mail" placeholder="hewlett.william@gmail.com">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="numero" class="text-info" style="color: #19b9cc">Numéro de téléphone*</label>
                            <input type="tel" class="form-control" id="numero" name="numero" minlength="8" maxlength="8">
                            <small id="numberHelpBlock" class="form-text text-muted">
                                Doit contenir 8 chiffres et commencer par 0</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="rue" class="text-info" style="color: #19b9cc">Rue*</label>
                            <input type="text" class="form-control" id="rue" name="rue" placeholder=" 14 rue de la Verrerie">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ville" class="text-info" style="color: #19b9cc">Ville*</label>
                            <input type="text" class="form-control" id="ville" name="ville" placeholder="Meudon">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="code" class="text-info" style="color: #19b9cc">Code Postal*</label>
                            <input type="text" class="form-control" id="code" name="code" minlength="5" maxlength="5" placeholder="92197">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="naissance" class="text-info" style="color: #19b9cc">Date de naissance</label>
                            <input type="date" class="form-control" id="naissance" name="naissance" placeholder="JJ-MM-YYYY">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="situation" class="text-info" style="color: #19b9cc">Situation Familiale </label>
                            <select class="form-control" name="situation" id="situation">
	                            <option value="---">---</option>
	                            <option value="Autre">Autre</option>
                                <option value="Célibataire">Célibataire</option>
                                <option value="Marié(e)">Marié(e)</option>
                                <option value="Pacsé(e)">Pacsé(e)</option>
                                <option value="Divorcé(e)">Divorcé(e)</option>
                                <option value="Séparé(e)">Séparé(e)</option>
                                <option value="Veuf(ve)">Veuf(ve)</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="sexe" class="text-info" style="color: #19b9cc">Sexe</label>
                            <select class="form-control" name="sexe" id="sexe">
	                            <option value="---">---</option>
	                            <option value="Autre">Autre</option>
                                <option value="Homme">Homme</option>
                                <option value="Femme">Femme</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="password" class="text-info" style="color: #19b9cc">Mot de Passe*</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="8" aria-describedby="passwordHelpBlock">
                            <small id="passwordHelpBlock" class="form-text text-muted">
                                Doit contenir au moins 8 caractères, commencer par une lettre majuscule et se terminer par un lettre minuscule, sans caractères spéciaux.
                            </small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password2" class="text-info" style="color: #19b9cc">Confirmation mot de passe*</label>
                            <input type="password" class="form-control" id="password2" name="password2">
                        </div>
                    </div>
                    <button type="submit" name="btn_register" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Créer un compte</button>
                </form>
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
<!--========== END FOOTER ==========-->
</body>
</html>
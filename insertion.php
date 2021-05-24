<?php
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "ProjectPHP";
$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

//Création de 6 produits //
$sql7 = "INSERT INTO Produits (id, refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES (1,'603a6C0ea#abf','HP Pavilion x360 14-dy0008nf', 'PC', 'HP', 17, 899,20,'Le HP Pavilion x360 14 convertible s’adapte à tous vos besoins pour vous permettre d’être productif sous n’importe quel angle. Regardez vos séries préférées aussi longtemps que vous le souhaitez grâce à HP Fast Charge. Avec ses deux haut-parleurs dotés d’un système audio par B&O, cet ordinateur portable vous offre le son et l’expérience de divertissement immersifs que vous recherchez. Conçu avec le souci du respect de l’environnement, le HP Pavilion x360 est fabriqué à partir de plastiques océaniques, durables et recyclés post-consommation')";
$resultat7 = mysqli_query($connect, $sql7); //creation d'un produit

$sql8 = "INSERT INTO Produits (id, refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES (2, '603j122aa#abb','Stylet inclinable rechargeable HP MPP2.0 (noir)', 'Autre', 'HP', 3, 399,20,'Laissez libre cours à votre créativité avec la technologie MPP2.0, qui réduit les délais, optimise la transition entre les couleurs et améliore la réactivité')";
$resultat8 = mysqli_query($connect, $sql8); //creation d'un produit

$sql9 = "INSERT INTO Produits (id, refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES (3, '601mr71b#nhc','HP OfficeJet Pro 9020 tout-en-un', 'Imprimante', 'HP', 77, 279,20,'Une imprimante intelligente révolutionnaire. Gagnez du temps avec les raccourcis Smart Tasks. Bénéficiez d’une numérisation recto-verso en une seule passe, d’une impression mobile en toute simplicité,de connexions sans faille, de la sécurité HP, la meilleure de sa catégorie. Économisez jusqu’à 70 % sur vos cartouches d’encre')";
$resultat9 = mysqli_query($connect, $sql9); //creation d'un produit

$sql10= "INSERT INTO Produits (id, refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES (4, '60#2228C02625','Canon PIXMA TS5151 - Blanc', 'Imprimante', 'Canon', 1, 79,20,'Imprimante multifonction familiale compacte et abordable avec connectivité intelligente pour imprimer, copier et numériser en toute simplicité à domicile.')";
$resultat10 = mysqli_query($connect, $sql10); //creation d'un produit

$sql11= "INSERT INTO Produits (id, refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES (5, '60#2228C02625','Cartouche d’encre à haut rendement Canon PG-540XL/CL-541XL + Pack économique de papiers photo', 'Autre', 'Canon', 56, 11,20,'Tout ce dont votre imprimante a besoin dans un pack à prix réduit comprenant encres et papier photo.')";
$resultat11 = mysqli_query($connect, $sql11); //creation d'un produit

$sql12= "INSERT INTO Produits (id, refe,libelle,cat,marque,stock, prix_unitaire, TVA,descr ) VALUES (6, '6000008377391','Tapis de souris Repose-poignet Noir', 'Autre', 'Boulanger', 0, 6,20,'Repose poignet en gel pour un confort d’utilisation personnalisé : soulage les tensions au niveau du poignet.Tissu Lycra.')";
$resultat12 = mysqli_query($connect, $sql12); //creation d'un produit

//Création d'un commentaire//

$sql14= "INSERT INTO Commentaire (id,nom,prenom,mail, commentaire) VALUES (1, 'Rodrigues','Camille', 'cam.6c@hotmail.fr', 'Tres satisfaite , une livraison super rapide en 24h! Ecran magnifique sans aucun défaut , que vouloir de plus ? je continuerai à commander chez eux sans aucun doute.')";
$resulta14 = mysqli_query($connect, $sql14);

$sql14= "INSERT INTO Commentaire (id,nom,prenom,mail, commentaire) VALUES (2, 'Laporte','Jacky', 'jacky.Laporte@gmail.com', 'Tres bonne expérience me concernant. Bon produit et surtout livré en 24h, sans frais. Je recommanderai sans hésiter !')";
$resulta14 = mysqli_query($connect, $sql14);

$sql15= "INSERT INTO Commentaire (id,nom,prenom,mail, commentaire) VALUES (3, 'Bonin','Danielle', 'dani.bonin@free.com', 'Ca fait 3 mois, qu’ils sont en rupture de stocks de tapis de souris. Il ne faut pas être pressé avec eux!')";
$resulta15 = mysqli_query($connect, $sql15);

try {
    $db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $password1 = password_hash('Camillou', PASSWORD_DEFAULT); //encrypt password using password_hash()
    $password2 = password_hash('Laporte', PASSWORD_DEFAULT); //encrypt password using password_hash()
    $password3 = password_hash('Danielle', PASSWORD_DEFAULT); //encrypt password using password_hash()

    $insert_stmt = $db->prepare("INSERT INTO Client(id, nom, prenom, mail, numero, rue, ville, code, situation, naissance, sexe, password) VALUES(:id,:nom,:prenom,:mail,:numero,:rue,:ville,:code,:situation,:naissance,:sexe,:password)");		//sql insert query
    $insert_stmt->execute(array(':id'=>1,':nom'	=>'Rodrigues', ':prenom'=>'Camille', ':mail'=>'cam.6c@hotmail.fr', ':numero' =>'0651188857', ':rue' =>'5 Rue Raspail', ':ville'	=>'Saint-Ouen', ':code'=>'93400', ':situation'=>'Célibataire', ':naissance'=>'1997-04-05', ':sexe' 	=>'Femme', ':password' =>$password1));


    $insert_stmt->execute(array(':id'=>2,':nom'	=>'Laporte', ':prenom'=>'Jacky', ':mail'=>'jacky.laporte@gmail.com', ':numero' =>'0682387681', ':rue' =>'10 rue Rablais', ':ville'	=>'Paris', ':code'=>'75010', ':situation'=>'---', ':naissance'=>'1976-03-12', ':sexe' 	=>'Homme', ':password' =>$password2));
    $insert_stmt->execute(array(':id'=>3,':nom'	=>'Bonin', ':prenom'=>'Danielle', ':mail'=>'dani.bonin@free.com', ':numero' =>'0792387664', ':rue' =>'10 avenue Paradis', ':ville'	=>'Paris', ':code'=>'75017', ':situation'=>'---', ':naissance'=>'1999-09-15', ':sexe' 	=>'Femme', ':password' =>$password3));
}
catch (PDOEXCEPTION $e) {
}
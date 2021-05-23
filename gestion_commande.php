<?php
require_once 'connection.php';
require_once 'db.php';

session_start();
$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

$errorMsg = $_GET['errorMsg'];
$successMsg = $_GET['successMsg'];
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

<!-- ======== HEADER ======== -->
<header class="header">
    <div class="bg-color-sky-light">
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
                                <a class="nav-item-child" href="gestion_client.php">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-item-child active" href="gestion_commande.php">Commande</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-item-child" href="ajouter_commentaire.php">Commentaires</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-item-child" href="consulter_profil.php">Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-item-child" href="deconnexion.php">Déconnexion</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<!-- ======== FIN HEADER ======== -->



<!-- ======== PAGE ======== -->
<div class="section-seperator">
    <div class="content-md container">
        <div class="col well">
	        <div style="align-content: center">
		        <h3 class="text-primary" style="color: #19b9cc" align="center">Produits</h3>
            <hr style="border-top:1px dotted #ccc;"/>

            <?php
            if(isset($errorMsg)) {
                ?>
                <div class="alert alert-danger">
                    <strong><?php echo $errorMsg; ?></strong>
                </div>
                <?php
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
			        <div class="row">
				        <div class="col-xs-3">
					        <label for="cat" class="text-info"  style="color: #19b9cc">Catégorie</label>
					        <select class="form-control" name="cat" id="cat">
                    <option value="Tout">Tout</option>
                    <option value="Autre">Autre</option>
                    <option value="pc">PC</option>
                    <option value="imprimante">Imprimante</option>
                    <option value="scanner">Scanner</option>
                </select>
				        </div>
				        <div class="col-xs-3">
					        <label for="marque" class="text-info"  style="color: #19b9cc">Marque</label>
					        <select class="form-control" name="marque" id="marque">
                    <option value="Tout">Tout</option>
                    <option value="Autre">Autre</option>
                    <option value="HP">HP</option>
                    <option value="cannon">Cannon</option>
                    <option value="boulanger">Boulanger</option>
                </select>
				        </div>
				        <div class="col-xs-3">
					        <label for="prixmin" class="text-info"  style="color: #19b9cc">Prix minimum</label>
					        <input type="text" class="form-control" id="prixmin" name="prixmin"/>
				        </div>
				        <div class="col-xs-3">
					        <label for="prixmax" class="text-info"  style="color: #19b9cc">Prix maximum</label>
					        <input type="text" class="form-control" id="prixmax" name="prixmax"/>
				        </div>
			        </div>
			        <div class="row">
				        <br/><br/>
				        <div class="col-xs-3">
					        <button type="submit" class="btn-theme btn-theme-sm btn-base-bg text-uppercase" name="recherche">Rechercher les produits</button>
				        </div>
			        </div>
		        </form>
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
                    <th class="text-center col-md-1">Quantité</th>
                    <th class="text-center col-md-1">Commander</th>
                </tr>
                </thead>
                <tbody style="background-color:#ffffff;">

                <?php
                require_once 'connection.php';
                $connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

                if(ISSET($_POST['recherche'])){
                    $categorie = $_POST['cat'];
                    $marque = $_POST['marque'];
                    $prixmin = $_POST['prixmin'];
                    $prixmax = $_POST['prixmax'];

                    if(empty($prixmin) && empty($prixmax)){
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
                        if($categorie!='Tout' && $marque!='Tout'){
                            $sql = "SELECT * FROM Produits WHERE cat='{$categorie}' AND marque='{$marque}' AND prix BETWEEN '{$prixmin}' AND '{$prixmax}'";
                        }
                        elseif($categorie!='Tout' && $marque='Tout'){
                            $sql = "SELECT * FROM Produits WHERE cat='{$categorie}' AND prix BETWEEN '{$prixmin}' AND '{$prixmax}'";
                        }
                        elseif($categorie='Tout' && $marque!='Tout'){
                            $sql = "SELECT * FROM Produits WHERE marque='{$marque}' AND prix BETWEEN '{$prixmin}' AND '{$prixmax}'";
                        }
                        elseif($categorie='Tout' && $marque='Tout'){
                            $sql = "SELECT * FROM Produits WHERE prix BETWEEN '{$prixmin}' AND '{$prixmax}'";
                        }
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
                        <form method="POST" action="ajout_panier.php?id=<?php echo $row['id']; ?>">
                            <th class="text-center col-md-1">
                                <input type="text" class="form-control" id="quantite" name="quantite"/>
                            </th>
                            <th >
                                <button type="submit" class="btn btn-info" name="commande">Commander</button>
                            </th>
                        </form>
                    </tr>
                    <?php
                }
                $i++;
                ?>
                </tbody>
            </table>
	        </div>

        </div>
    </div>
</div>
</body>
<!-- ======== FIN PAGE ======== -->


<!-- ======== FOOTER ======== -->
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
<!-- ======== FIN FOOTER ======== -->
</html>

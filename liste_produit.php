

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
                            <a class="nav-item-child active" href="gestion_admin.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item-child"  href="gestion_produit.php">Gérer Produit</a>
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
            <h3 style="color: #19b9cc" align="center"> Administrateur
            </h3>
        </div>
    </nav>
</header>





<div class="section-seperator">
    <div class="content-md container">
        <div class="col well">
            <h3 class="text-primary">Produits</h3>
            <hr style="border-top:1px dotted #ccc;"/>
            <form method="POST" action="">
                <label for="cat" class="text-info"  style="color: #19b9cc">Catégorie</label>
                <select class="form-control" name="cat" id="cat">
                    <option value="Autre">Autre</option>
                    <option value="pc">PC</option>
                    <option value="imprimante">Imprimante</option>
                    <option value="scanner">Scanner</option>
                </select>

                <label for="marque" class="text-info"  style="color: #19b9cc">Marque</label>
                <select class="form-control" name="marque" id="marque">
                    <option value="Autre">Autre</option>
                    <option value="HP">HP</option>
                    <option value="cannon">Cannon</option>
                    <option value="boulanger">Boulanger</option>
                </select>

                <button type="submit" class="btn btn-info" name="recherche">Rechercher les produits</button>
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
                    <th class="text-center col-md-1">Modifier</th>
                    <th class="text-center col-md-1">Supprimer</th>
                </tr>
                </thead>
                <tbody style="background-color:#ffffff;">

                <?php
                require_once 'connection.php';
                $connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

                if(ISSET($_POST['recherche'])){
                    $categorie = $_POST['cat'];
                    $marque = $_POST['marque'];
                    $sql = "SELECT * FROM Produits WHERE cat='{$categorie}' AND marque='{$marque}'";
                }
                else{
                    $sql = "SELECT * FROM Produits";
                }

                $stmt = mysqli_prepare($connect,$sql);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

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
                            <button type="submit" name="modifier" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Modifier</button>
                        </th>
                        <th class="text-center col-md-1">
                            <button type="submit" name="supprimer" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Supprimer</button>
                        </th>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
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
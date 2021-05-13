<?php
require_once 'connexion.php';
include 'db.php';

session_start();
if(!isset($_SESSION['user_login'])) {
    header("location: index.php");
}

$connect = mysqli_connect("localhost", "root", "", "ProjectPHP");

if(isset($_REQUEST['btn'])) {
    $cat		    = strip_tags($_REQUEST['cat']);
    $marque 	    = strip_tags($_REQUEST['marque']);
    $prix_minimal   = strip_tags($_REQUEST['Prix minimal']);
    $prix_maximal   =strip_tags($_REQUEST['Prix maximal']);

    if(empty($prix_minimal)) {
        $errorMsg[] = "Veuillez entrer un prix minimal ";
    }
    if(empty($prix_maximal)) {
        $errorMsg[] = "Veuillez entrer un prix maximal";
    }
else {

    $connect = mysqli_connect("localhost", "root", "", "ProjectPHP");
?>


<--------- Page --------->
<div class="col well">
    <h3 class="text-primary" style="color: #19b9cc" align="center"> Faire une commande  </h3>
    <hr style="border-top:1px dotted #ccc;"/>

    <form method="GET" action="gestion_commande.php">
        <div class="row">

            <div class="form-group col-md-3">
                <label for="cat" class="text-info" style="color: #19b9cc">Catégorie</label>
                <select class="form-control" name="cat" id="cat">
                    <option value="Autre">Autre</option>
                    <option value="pc">PC</option>
                    <option value="imprimante">Imprimante</option>
                    <option value="scanner">Scanner</option>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="marque" class="text-info" style="color: #19b9cc">Marque</label>
                <select class="form-control" name="marque" id="marque">
                    <option value="Autre">Autre</option>
                    <option value="HP">HP</option>
                    <option value="cannon">Cannon</option>
                    <option value="boulanger">Boulanger</option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="prix minimal" class="text-info" style="color: #19b9cc">Prix minimal</label>
                <input type="number" class="form-control" id="prix" name="prix" placeholder="12,99"/>
            </div>

            <div class="form-group col-md-4">
                <label for="prix minimal" class="text-info" style="color: #19b9cc">Prix maximal</label>
                <input type="number" class="form-control" id="prix" name="prix" placeholder="12,99"/>
            </div>

            <div class="form-group col-md-6">

                <button type="submit" name="btn_add" class="btn-theme btn-theme-sm btn-base-bg text-uppercase">Rechercher</button>
            </div>
        </div>
    </form>
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
</div>
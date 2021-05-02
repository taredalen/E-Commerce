<?php

$db_host="localhost";
$db_user="root";
$db_password="";
$db_name="ProjectPHP";

try {
    // Create connection to server
    $db = new mysqli($db_host, $db_user, $db_password);
    // Create database
    $sql = "CREATE DATABASE ProjectPHP";
    mysqli_query($db, $sql);
    /*if(mysqli_query($db, $sql)){
    echo "Database created successfully";
    }
    else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
    }*/
}
catch(EXCEPTION $e) {
    echo $e;
}

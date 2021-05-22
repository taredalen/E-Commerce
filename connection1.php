<?php
$db_host="localhost";
$db_user="root";
$db_password="";
$db_name="ProjectPHP";

// Create connection
$db = new mysqli($db_host, $db_user, $db_password,$db_name);

try {
    $db = mysqli_connect("localhost", "root", "", "ProjectPHP");
}
catch(EXCEPTION $e) {
    echo $e;
}
?>
<?php
session_start();

header("location:index.php");

if(isset($_COOKIE['id'])){
    setcookie("id", $_SESSION['id'], time()-3600*24*5);
}

if(isset($_COOKIE['id'])) {
	setcookie("id", $_SESSION['id'], time()- 3600 * 24 * 5 );
}
session_destroy();

?>
<?php

session_start();

session_destroy(); 

$_SESSION = array(); //Se limpia la session

header('Location: login.php');

?>
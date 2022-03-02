<?php

session_start();
 //Similar al index, si existe sesion nos muestra el contenido llamandolo mediante el require.
if(isset($_SESSION['usuario'])){
    require 'views/contenido.view.php';
}else{
    header('Location: login.php');
}

?>


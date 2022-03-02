<?php

//Si no existe session nos mandara a registrarnos, de lo contrario nos mandara al contenido
session_start();
if(isset($_SESSION['usuario'])){
    header('Location: contenido.php');

}else{
    header('Location: registrate.php');
}

?>
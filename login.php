<?php

session_start();

if(isset($_SESSION['usuario'])){
    header('Location: index.php');
}

$errores = '';

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $usuario = filter_var(strtolower($_POST['usuario']),FILTER_SANITIZE_STRING); //Realizando filtro par obtener un dato limpio
    $password = $_POST['password'];
    $password = hash('sha512',$password); //encriptando

    try{
        $conexion = new PDO('mysql:host=localhost;dbname=curso_login','root',''); //Conexion a BD
    }catch(PDOException $e){
        echo "Error: " .$e->getMessage();
    }

    $statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuario = :usuario AND pass = :password');
    $statement -> execute(array
    (':usuario'=> $usuario,':password'=>$password));

    $resultado = $statement->fetch(); 
    if($resultado !== false){ // Resultado incorrecto, no existe ese usuario o contraseña,  variable errores usa manejo de la misma.
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
    }else{
        $errores = '<li>Datos Incorrectos</li>';
    }

}


require 'views/login.view.php'

?>
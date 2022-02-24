<?php
session_start();


if (isset($_SESSION['usuario'])){
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){ //SI EL METODO DE ENVIO ES POST, ENTONCES SE ENVIARON
    $usuario = filter_var(strtolower($_POST['usuario']),FILTER_SANITIZE_STRING); //Se filtra para limpiarlo y entregar el resultado en miniscula
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $erorres ='';

    if(empty($usuario) or empty($password) or empty($password2)){
        $errores = '<li>Por favor rellena todos los datos correctamente </li>';
    }else{
        try{
            $conexion = new PDO('mysql:host=localhost;dbname=curso_login','root','');
        }catch(PDOException $e){
            echo "Error: ". $e->getMessage();
        }

        $statement = $conexion -> prepare('SELECT * FROM usuarios WHERE usuario = :usuario LIMIT 1');
        $statement->execute(array(':usuario' => $usuario));
        $resultado = $statement->fetch();

        if($resultado != false){ //Existe el usuario
            $errores = '<li> El nombre de usuario ya existe </li>';
        }

        $password = hash('sha512',$password); //Encriptando contraseñas
        $password2 = hash('sha512',$password2);

        if($password != $password2){
            $errores = '<li> Las contraseñas no son iguales </li>';
        }
      
    }

    if ($errores == '') { //Si no existe ningun error crea el insert.
		$statement = $conexion->prepare('INSERT INTO usuarios (id, usuario, pass) VALUES (null, :usuario, :pass)');
		$statement->execute(array(
				':usuario' => $usuario,
				':pass' => $password
			));
        header('Location: login.php');
    }
} 


require 'views/registrate.view.php';
?>
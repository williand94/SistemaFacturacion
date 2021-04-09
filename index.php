<?php
    /*<?php $alert= "hola " ;echo isset($alert) ? $alert : '';?>*/
       
        $alert = "";
        /* 1)Realizamos la validación para ver si existe algo en la Variable $_POST. 
        2)En la línea 8 verificamos si existe o hay algo en las variabeles $_POST["usuario"]y $_POST["clave"].
        3)Si entramos en el else, llamamos a la conexión de la BD y verficamos mediante una consulta , si existe el usuario 
        y contraseña logueados. */

        /*  En el primer if verificamos si existe la $_SESSION["active"], y si sí existe nos 
            redirecciona a header('location: sistema/');
            De lo contrario, realizamos el proceso de logueo.

            DEBEMOS SIEMPRE INICIALIZAR LAS VARIABLES DE SESIÓN, PARA PODERLAS UTILIZAR.
            EN LA LÍNEA 16 INICIALIZAMOS session_start(), para que se pueda encontrar la variable $_SESSION["active"].
        */ 
    session_start();
    if(!empty($_SESSION["active"]))
    {
        header('location: sistema/');

    }
    else{
                
        if(!empty($_POST))
        {
            if(empty($_POST["usuario"]) || empty($_POST["clave"]) )
            {
                $alert = "Ingrese su usuario y contraseña por favor.";
            }
            else{
                require("conexion.php");
                /* mysqli_real_escape_string sirve para evitar caractéres raros, con el fin de evitar inyección sql */
                $user = mysqli_real_escape_string($conection,$_POST["usuario"]) ;
                $pass = md5(mysqli_real_escape_string($conection,$_POST["clave"]));

                $query = mysqli_query($conection,"SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$pass'");
                mysqli_close($conection);

                $result = mysqli_num_rows($query);
                if($result > 0)
                {
                    $data = mysqli_fetch_array($query);

                    $_SESSION["result"] = $result;
                    $_SESSION["active"] = true;
                    $_SESSION["idUser"] = $data["idusuario"];
                    $_SESSION["nombre"] = $data["nombre"];
                    $_SESSION["email"]  = $data["correo"];
                    $_SESSION["user"]   = $data["usuario"];
                    $_SESSION["rol"]    = $data["rol"];

                    header('location: sistema/');

                }
                else{
                    $alert = "El usuario o contraseña son incorrectos, o no está registtrado!";
                    session_destroy();
                }

            }
        }
    }  
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistema Facturación</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">  
</head>
<body>
    <section id="container">

        <form action="" method="post">

            <h3>Iniciar Sesión</h3>
            <img class="img" src="img/bg1.jpg" alt="Login"> 
            <input type="text" name="usuario" placeholder="Usuario">
            <input type="password" name="clave" placeholder="Contraseña">
            <div class="alert"><?php echo isset($alert) ? $alert : '' ;?></div>
            <input type="submit" value="INGRESAR">
        </form>
    </section>
</body>
</html>

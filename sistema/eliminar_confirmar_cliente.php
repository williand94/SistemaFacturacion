<?php 
    session_start();
        
    if($_SESSION["rol"] != 1 AND $_SESSION["rol"] !=2){
        header("Location: ./");
    }

    include "../conexion.php";

    //Verifico si existe el id, y realizo la consulta para mostrar los datos a eliminar.
    if(empty($_REQUEST["id"]))
    {
        header("location: lista_clientes.php");
        mysqli_close($conection);
    }else{
        //Recupero el id, que mandé desde la pagina lista_clientes.php
        $idcliente = $_REQUEST["id"];

        $query = mysqli_query($conection,"SELECT * FROM cliente  WHERE idcliente = $idcliente");
        //mysqli_close($conection);
        $result = mysqli_num_rows($query);
        
        if($result > 0)
        {
            while($data = mysqli_fetch_array($query))
            {
                $nit       = $data["nit"];
                $nombre    = $data["nombre"];
                $telefono  = $data["telefono"];
                $direccion = $data["direccion"];
            }
        }else{
            header("location: lista_clientes.php");

        }
    }

    if(!empty($_POST))
    {
       
        if(empty($_POST['idcliente']))
        {
          header("location: lista_clientes.php");
        }
        $idcliente = $_POST['idcliente'];

        //$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =  $idUsuario");
        $query_delete = mysqli_query($conection,"UPDATE cliente SET estatus = 0 where idcliente = $idcliente");
        mysqli_close($conection);  
        
        $alert = "";
        if($query_delete)
        {
          $alert= "Cliente eliminado correctamente.";  
          //header("location: lista_clientes.php");
        }else{
            echo "Error al eliminar";
        }
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Eliminar Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
            <h2>¿Está seguro de eliminar el siguiente usuario?</h2>
            <p>Nit:<span><?php echo $nit; ?></span></p>
            <p>Nombre:<span><?php echo $nombre; ?></span></p>
            <p>Teléfono:<span><?php echo $telefono; ?></span></p>
            <p>Dirección:<span><?php echo $direccion; ?></span></p>

            <form method="POST" action="">
                <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
                <a href="lista_usuarios.php" class="btn_cancel">Cancelar</a>
                <!-- <input type="submit" name="delete" value="Aceptar" class="btn_ok"> -->
                <button type="submit" name="delete" class="btn_ok">Aceptar</button>
            </form>   
            <div class="alert"><?php echo isset($alert) ?$alert :'';?></div>
        </div>
	</section>

	<?php include "includes/footer.php"; ?>	
</body>
</html>
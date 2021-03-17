<?php 
    session_start();
        
    if($_SESSION["rol"] != 1){
        header("Location: ./");
    }

    include "../conexion.php";

    if(!empty($_POST))
    {
        if($_POST['idusuario'] == 1 ){
          header("location: lista_usuarios.php");
          mysqli_close($conection);
          exit;  
        }

        $idUsuario = $_POST['idusuario'];

        //$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =  $idUsuario");
        $query_delete = mysqli_query($conection,"UPDATE usuario SET estatus = 0 where idusuario = $idUsuario");
        mysqli_close($conection);   
        if($query_delete)
        {
          header("location: lista_usuarios.php");
        }else{
            echo "Error al eliminar";
        }
    }

    if(empty($_REQUEST["id"]) || $_REQUEST["id"] == 1)
    {
        header("location: lista_usuarios.php");
        mysqli_close($conection);
    }else{
    
        $idUsuario = $_REQUEST["id"];

        $query = mysqli_query($conection,"SELECT u.nombre, u.usuario, r.rol
                                          FROM usuario u
                                          INNER JOIN
                                          rol r
                                          on u.rol = r.idrol
                                          WHERE u.idusuario = $idUsuario");
        mysqli_close($conection);
        $result = mysqli_num_rows($query);
        
        if($result > 0)
        {
            while($data = mysqli_fetch_array($query))
            {
                $nombre = $data["nombre"];
                $usuario = $data["usuario"];
                $rol = $data["rol"];
            }
        }else{
            header("location: lista_usuarios.php");

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
            <i class="fas fa-user-times fa-7x "style="color:#e40017"></i>
            <br><br>
            <h2>¿Está seguro de eliminar el siguiente usuario?</h2>
            <p>Nombre:<span><?php echo $nombre; ?></span></p>
            <p>Usuario:<span><?php echo $usuario; ?></span></p>
            <p>Rol:<span><?php echo $rol; ?></span></p>

            <form method="POST" action="">
                <input type="hidden" name="idusuario" value="<?php echo $idUsuario; ?>">
                <a href="lista_usuarios.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
                <!-- <input type="submit" value="Aceptar" class="btn_ok"> -->
                <button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Aceptar</button>
            </form>   
        </div>
	</section>

	<?php include "includes/footer.php"; ?>	
</body>
</html>
<?php 
    session_start();
        
    if($_SESSION["rol"] != 1 AND $_SESSION["rol"] !=2){
        header("Location: ./");
    }

    include "../conexion.php";

    //Verifico si existe el id, y realizo la consulta para mostrar los datos a eliminar.
    if(empty($_REQUEST["id"]))
    {
        header("location: lista_proveedor.php");
        mysqli_close($conection);
    }else{
        //Recupero el id, que mandé desde la pagina lista_clientes.php
        $codproveedor = $_REQUEST["id"];

        $query = mysqli_query($conection,"SELECT * FROM proveedor  WHERE codproveedor = $codproveedor");
        //mysqli_close($conection);
        $result = mysqli_num_rows($query);
        
        if($result > 0)
        {
            while($data = mysqli_fetch_array($query))
            {
                $proveedor = $data["proveedor"];               
            }
        }else{
            header("location: lista_proveedor.php");

        }
    }

    if(!empty($_POST))
    {
       
        if(empty($_POST['codproveedor']))
        {
          header("location: lista_proveedor.php");
        }
        $codproveedor = $_POST['codproveedor'];

        //$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =  $idUsuario");
        $query_delete = mysqli_query($conection,"UPDATE proveedor SET estatus = 0 where codproveedor = $codproveedor");
        mysqli_close($conection);  
        
        $alert = "";
        if($query_delete)
        {
          $alert= "Proveedor eliminado correctamente.";  
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
	<title>Eliminar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
            <i class="far fa-building fa-7x "style="color:#e40017"></i>
            <br><br>
            <h2>¿Está seguro de eliminar el siguiente Proveedor?</h2>
            <p>Proveedor:<span><?php echo $proveedor; ?></span></p>
        
            <form method="POST" action="">
                <input type="hidden" name="codproveedor" value="<?php echo $codproveedor; ?>">
                <a href="lista_proveedor.php" class="btn_cancel">Cancelar</a>
                <!-- <input type="submit" name="delete" value="Aceptar" class="btn_ok"> -->
                <button type="submit" name="delete" class="btn_ok"><i class="far fa-trash-alt"></i>Aceptar</button>

            </form>   
            <div class="alert"><?php echo isset($alert) ?$alert :'';?></div>
        </div>
	</section>

	<?php include "includes/footer.php"; ?>	
</body>
</html>
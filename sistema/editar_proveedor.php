<?php
   session_start();
   if($_SESSION["rol"] != 1 AND $_SESSION["rol"] != 2)
   {
       header("Location: ./");
   }
   include "../conexion.php";

    //Mostrar datos
    /* COn esta línea de código -->var_dump($_REQUEST["id"]); , lo que comprobmaos es que al hacer click en editar 
    un usuario la variable $_REQUEST["id"] */
    if(empty($_REQUEST["id"]))
    {
        header("location: lista_proveedor.php");
        mysqli_close($conection);

    }
    $codproveedor = $_REQUEST["id"];
    
    $sql = mysqli_query($conection,"SELECT * FROM proveedor WHERE codproveedor = $codproveedor AND estatus = 1");
    $result_sql = mysqli_num_rows($sql);
    
    if($result_sql == 0)
    {
        header("location: lista_proveedor.php");

    }else{

        while($data = mysqli_fetch_array($sql)){

            $codproveedor  = $data["codproveedor"];
            $proveedor     = $data["proveedor"];
            $contacto      = $data["contacto"];
            $telefono      = $data["telefono"];
            $direccion     = $data["direccion"];

           
        }
    } 
    
     /* El if se ejecuta siempre y cuando le demos click al botón actualizar */
     if(!empty($_POST))
     {
         $alert='';
         if(empty($_POST["proveedor"]) || empty($_POST["contacto"]) || empty($_POST["telefono"]) || empty($_POST["direccion"]))
         {
             $alert = '<p class="msg_error">Todos lo campos son obligatorios.</p>';
                    
         }else{
            
            $codproveedor  = $_POST["id"];
            $proveedor     = $_POST["proveedor"];
            $contacto      = $_POST["contacto"];
            $telefono      = $_POST["telefono"];
            $direccion     = $_POST["direccion"];

            $sql_update = mysqli_query($conection,"UPDATE proveedor SET proveedor = '$proveedor', contacto ='$contacto', telefono = $telefono , direccion = '$direccion'
                                                   WHERE codproveedor = $codproveedor");
    
 
            if($sql_update)
            {
                $alert = '<p class="msg_save">Proveedor actualizado correctamente.</p>';
            }else{
                $alert = '<p class="msg_error">Error al actualizar el proveedor.</p>';
 
            }          
                      
 
 
         }
 
         mysqli_close($conection);
 
         
     }

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Actualizar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

        <div class="form_register">
            <h1><i class="far fa-edit"></i> Actualizar Proveedor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $codproveedor;?>">
                <label for="proveedor">Proveedor</label>
                <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del Proveedor" value="<?php echo $proveedor;?>">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" id="contacto" placeholder="Nombre completo del contacto" value="<?php echo $contacto;?>">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono;?>">
                <label for="direccion">Dirección</label>           
                <input type="text" name="direccion" id="direccion" placeholder="Dirección completa" value="<?php echo $direccion;?>">
                <!-- <input type="submit" value="Actualizar Proveedor" class="btn_save"> -->
                <button type="submit" class="btn_save"><i class="far fa-edit"></i> Actualizar Proveedor</button>
            </form>
        </div>
	</section>

	<?php include "includes/footer.php"; ?>	
</body>
</html>
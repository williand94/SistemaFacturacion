<?php

   session_start();
   if($_SESSION["rol"] != 1 AND $_SESSION["rol"] !=2)
   {
       header("Location: ./");
   } 
   include "../conexion.php";

    if(!empty($_POST))
    {
        $alert='';
        if(empty($_POST["proveedor"]) || empty($_POST["contacto"])||empty($_POST["telefono"])||empty($_POST["direccion"]))
        {
            $alert = '<p class="msg_error">Todos lo campos son obligatorios.</p>';
                   
        }else{

            $proveedor  = $_POST["proveedor"];
            $contacto     = $_POST["contacto"];
            $telefono   = $_POST["telefono"];
            $direccion  = $_POST["direccion"];
            $usuario_id = $_SESSION["idUser"];

            $query_insert = mysqli_query($conection,"INSERT INTO proveedor(proveedor,contacto,telefono,direccion,usuario_id)
                                                        VALUES('$proveedor','$contacto',$telefono,'$direccion','$usuario_id')");
                 if($query_insert)
                 {
                     $alert = '<p class="msg_save">Proveedor guardado correctamente.</p>';
                 }else{
                     $alert = '<p class="msg_error">Error al guardar proveedor.</p>';
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
	<title>Registro Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

        <div class="form_register">
            <h1><i class="far fa-building"></i> Registro Proveedor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <label for="proveedor">Proveedor</label>
                <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del proveedor">
                <label for="contacto">Contacto</label>
                <input type="text" name="contacto" id="contacto" placeholder="Nombre de contacto">
                <label for="telefono">Tel??fono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Tel??fono">
                <label for="direccion">Direcci??n</label>           
                <input type="text" name="direccion" id="direccion" placeholder="Direcci??n completa">
                <!-- <input type="submit" value="Guardar Cliente" class="btn_save"> -->
                <button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Proveedor</button>
            </form>

        </div>

	</section>

	<?php include "includes/footer.php"; ?>	
</body>
</html>
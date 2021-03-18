<?php
   session_start();
   include "../conexion.php";

    //Mostrar datos
    /* COn esta línea de código -->var_dump($_REQUEST["id"]); , lo que comprobmaos es que al hacer click en editar 
    un usuario la variable $_REQUEST["id"] */
    if(empty($_REQUEST["id"]))
    {
        header("location: lista_clientes.php");
        mysqli_close($conection);

    }
    $id_cliente = $_REQUEST["id"];
    
    $sql = mysqli_query($conection,"SELECT * FROM cliente WHERE idcliente = $id_cliente AND estatus = 1");
    $result_sql = mysqli_num_rows($sql);
    
    if($result_sql == 0)
    {
        header("location: lista_clientes.php");

    }else{

        while($data = mysqli_fetch_array($sql)){

            $idcliente  = $data["idcliente"];
            $nit        = $data["nit"];
            $nombre     = $data["nombre"];
            $telefono   = $data["telefono"];
            $direccion  = $data["direccion"];

           
        }
    } 
    
     /* El if se ejecuta siempre y cuando le demes click al botón actualizar */
     if(!empty($_POST))
     {
         $alert='';
         if(empty($_POST["nombre"]) || empty($_POST["telefono"]) || empty($_POST["direccion"]))
         {
             $alert = '<p class="msg_error">Todos lo campos son obligatorios.</p>';
                    
         }else{
            
            $idCliente  = $_POST["id"];
            $nit        = $_POST["nit"];
            $nombre     = $_POST["nombre"];
            $telefono   = $_POST["telefono"];
            $direccion  = $_POST["direccion"];

            $result = 0;
            if(is_numeric($nit) AND $nit!=0)
            {
                
                $query = mysqli_query($conection, "SELECT * FROM cliente 
                                                          WHERE (nit = '$nit' AND idcliente != $idCliente)
                                                         ");
                $result = mysqli_fetch_array($query);
                $result = count((array)$result);
            }

 
             if($result > 0) 
             {
                 $alert = '<p class="msg_error">EL Nit ya existe, ingrese otro por favor.</p>';
 
             }else{

                 if($nit == '')
                 {
                     $nit == 0;
                 }

                 $sql_update = mysqli_query($conection,"UPDATE cliente 
                                                            SET nit = $nit, nombre='$nombre', telefono = '$telefono', direccion = '$direccion'
                                                            WHERE idcliente = $idCliente");
    
 
                 if($sql_update)
                 {
                     $alert = '<p class="msg_save">Cliente actualizado correctamente.</p>';
                 }else{
                     $alert = '<p class="msg_error">Error al actualizar el cliente.</p>';
 
                 }          
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
	<title>Actualizar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

        <div class="form_register">
            <h1><i class="far fa-edit"></i> Actualizar Cliente</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $idcliente;?>">
                <label for="nit">NIT</label>
                <input type="number" name="nit" id="nit" placeholder="Número de NIT" value="<?php echo $nit;?>">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre;?>">
                <label for="telefono">Teléfono</label>
                <input type="number" name="telefono" id="telefono" placeholder="Teléfono" value="<?php echo $telefono;?>">
                <label for="direccion">Dirección</label>           
                <input type="text" name="direccion" id="direccion" placeholder="Dirección completa" value="<?php echo $direccion;?>">
                <!-- <input type="submit" value="Actualizar Cliente" class="btn_save"> -->
                <button type="submit" class="btn_save"><i class="far fa-edit"></i> Actualizar Cliente</button>
            </form>


        </div>

	</section>

	<?php include "includes/footer.php"; ?>	
</body>
</html>
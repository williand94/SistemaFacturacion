<?php
	session_start();
    
	include "../conexion.php";	
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Lista de clientes</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
        
        <?php
        
            $busqueda = strtolower($_REQUEST['busqueda']);
            
            if(empty($busqueda))
            {
                header("Location: lista_clientes.php");
				mysqli_close($conection);
            }
        
        ?>
        
        <h1>Lista de Clientes</h1>
		<a href="registro_cliente.php" class="btn_new">Crear cliente</a>
		
		<form action="buscar_cliente.php" method="GET" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda;?>">
			<input type="submit" value="Buscar" class="btn_search">
		</form>
		
			
		<table>
			<tr>
				<th>Id</th>
				<th>Nit</th>
				<th>Nombre</th>
				<th>Teléfono</th>
				<th>Dirección</th>
				<th>Acciones</th> 
			</tr>
			<?php 
                //Paginador          
				$sql_resgister = mysqli_query($conection," SELECT COUNT(*) AS total_registro FROM cliente 
                                                                           WHERE
                                                                           (
                                                                           idcliente   LIKE '%$busqueda%' OR
                                                                           nit         LIKE '%$busqueda%' OR
                                                                           nombre      LIKE '%$busqueda%' OR
                                                                           telefono    LIKE '%$busqueda%' OR    
                                                                           direccion   LIKE '%$busqueda%'   
                                                                           )
                                                                           AND estatus = 1");

                $result_register = mysqli_fetch_array($sql_resgister);
                
				$total_registro = $result_register['total_registro'];
				
				$por_pagina = 10;

				if(empty($_GET['pagina']))
				{
					$pagina = 1;
				}else{
					$pagina = $_GET['pagina'];
				}

				$desde = ($pagina - 1) * $por_pagina;
				$total_paginas = ceil($total_registro/$por_pagina);

				$query = mysqli_query($conection,"SELECT * FROM cliente
								                  WHERE
                                                    (
                                                        idcliente LIKE '%$busqueda%' OR
                                                        nit       LIKE '%$busqueda%' OR
                                                        nombre    LIKE '%$busqueda%' OR    
                                                        telefono  LIKE '%$busqueda%' OR 
                                                        direccion LIKE '%$busqueda%')

                                                    AND estatus = 1 ORDER BY idcliente ASC  LIMIT $desde , $por_pagina");
                  
			    mysqli_close($conection);
			    $result = mysqli_num_rows($query);
                
				if($result > 0)
				{
				    while($data = mysqli_fetch_array($query)){
					
                        if($data["nit"] == 0)
                        {
                            $nit = 'C/F';
                        }else {
                            $nit = $data["nit"];
                        }				
			?>	
			<tr>
				<td><?php echo $data["idcliente"];?></td>
				<td><?php echo $nit;?></td>
				<td><?php echo $data["nombre"];?></td>
				<td><?php echo $data["telefono"];?></td>
				<td><?php echo $data["direccion"];?></td>
				<td>
			
					<a class="link_edit" href="editar_cliente.php?id=<?php echo $data["idcliente"];?>">Editar</a>
					|
					<?php if($_SESSION["rol"] == 1){?>
					
					<a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["idcliente"];?>">Eliminar</a>
		
					<?php } ?>
		 <?php
				}
			}
	
		 ?>		
				</td>

			</tr>
			
		</table>
		<?php 
		  if($total_paginas != 0){

		  	
		?>	
		<div class="paginador">
			<ul>
				<?php if($pagina != 1){

				?>	
				<li><a href="?pagina=<?php echo 1;?>&busqueda=<?php echo $busqueda;?>"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="?pagina=<?php echo $pagina - 1;?>&busqueda=<?php  $busqueda;?>"><i class="fas fa-caret-left fa-lg"></i></a></li>
				<?php
				}
					for($i=1; $i <= $total_paginas; $i++){
				
						if($i == $pagina)
						{
							echo'<li class="pageSelected">'.$i.'</li>';

						}else{

							echo'<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
						}
					}

					if($pagina != $total_paginas)
					{
				
				?>
				<li><a href="?pagina=<?php echo $pagina + 1;?>&busqueda=<?php  $busqueda;?>"><i class="fas fa-caret-right fa-lg"></i></a></li>
				<li><a href="?pagina=<?php echo $total_paginas;?>&busqueda=<?php  $busqueda;?>"><i class="fas fa-step-forward"></i></a></li>
					<?php }?>	

			</ul>
		</div><?php }?>	
	</section>

	<?php include "includes/footer.php"; ?>	
</body>
</html>
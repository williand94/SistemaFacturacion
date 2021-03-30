<?php 
	session_start();
   	include "../conexion.php";	
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php";?>
	<title>Lista de Productos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<h1><i class="fas fa-cube"></i> Lista de Productos</h1>
		<a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Registrar producto</a>
		
		<form action="buscar_producto.php" method="GET" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<!-- <input type="submit" value="Buscar" class="btn_search"> -->
			<button type="submit"  class="btn_search"><i class="fas fa-search"></i></button>

		</form>
		
			
		<table>
			<tr>
				<th>Código</th>
				<th>Descripcción</th>
				<th>Precio</th>
				<th>Existencia</th>
				<th>Proveedor</th>
				<th>Fotos</th> 
				<th class="center">Acciones</th> 
			</tr>
			<?php 
				//Paginador
				$sql_resgister = mysqli_query($conection," SELECT COUNT(*) AS total_registro FROM producto where estatus = 1");
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

				$query = mysqli_query($conection,"SELECT p.codproducto, p.descripcion, p.precio, p.existencia,
														 pr.proveedor,p.foto
												  FROM producto p
												  INNER JOIN proveedor pr
												  ON p.proveedor = pr.codproveedor
								                  WHERE p.estatus = 1 ORDER BY p.codproducto DESC LIMIT $desde , $por_pagina");
			
				mysqli_close($conection);
			
				$result = mysqli_num_rows($query);

				if($result > 0)
				{
				while($data = mysqli_fetch_array($query)){
					
                    if($data["foto"] != 'img_producto.jpg')
                    {
                        $foto = 'img/uploads/'.$data["foto"];
                    }else {
                        $foto = 'img/'.$data["foto"];
                    }					
			?>	
			<tr>
				<td><?php echo $data["codproducto"];?></td>
				<td><?php echo $data["descripcion"];?></td>
				<td><?php echo $data["precio"];?></td>
				<td><?php echo $data["existencia"];?></td>
				<td><?php echo $data["proveedor"];?></td>
				<td class="img_producto"><img src="<?php echo $foto;?>" alt="<?php echo $data["descripcion"];?>"> </td>
			
				<?php if($_SESSION['rol'] == 1){?>

				<td class="centerTD">	
					<a class="link_add center" href="agregar_producto.php?id=<?php echo $data["codproducto"];?>"><i class="fas fa-plus"></i>
					Agregar</a>
					|		
					<a class="link_edit center" href="editar_producto.php?id=<?php echo $data["codproducto"];?>"><i class="far fa-edit"></i>
					Editar</a> 
										

					| <a class="link_delete center" href="eliminar_confirmar_producto.php?id=<?php echo $data["idcliente"];?>"><i class="far fa-trash-alt"></i> 
					Eliminar</a>
				</td>

				<?php }?>	
		
		 <?php
				}
			}
	
		 ?>		

			</tr>
			
		</table>

		<div class="paginador">
			<ul>
				<?php if($pagina != 1){

				?>	
				<li><a href="?pagina=<?php echo 1;?>"><i class="fas fa-step-backward"></i></a></li>
				<li><a href="?pagina=<?php echo $pagina - 1;?>"><i class="fas fa-caret-left fa-lg"></i></a></li>
				<?php
				}
					for($i=1; $i <= $total_paginas; $i++){
				
						if($i == $pagina)
						{
							echo'<li class="pageSelected">'.$i.'</li>';

						}else{

							echo'<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
						}
					}

					if($pagina != $total_paginas)
					{
				
				?>
				<li><a href="?pagina=<?php echo $pagina + 1;?>"><i class="fas fa-caret-right fa-lg"></i></a></li>
				<li><a href="?pagina=<?php echo $total_paginas;?>"><i class="fas fa-step-forward"></i></a></li>
					<?php }?>	

			</ul>
		</div>	
	</section>

	<?php include "includes/footer.php"; ?>	
</body>
</html>
<?php
    include "../conexion.php";
    session_start();
    //print_r($_POST); exit;

    if (!empty($_POST)) {

        //Extraer datos del producto.
        if ($_POST['action'] == 'infoProducto') {

            $producto_id = $_POST['producto'];

            $query = mysqli_query($conection,"SELECT codproducto,descripcion FROM producto
                                              WHERE codproducto = $producto_id AND estatus = 1");
            mysqli_close($conection);                                  
            
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                $data = mysqli_fetch_assoc($query);
                //Retornamos en un formato JSON el array $data.
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
                exit;
            }
            echo "Error.";
            
            exit;
        }
        //Agregar productos a entrada.
        if ($_POST['action'] == 'addProduct') {

            if(!empty($_POST['cantidad']) || !empty($_POST['precio']) || !empty($_POST['producto_id']))
            {
                $cantidad    = $_POST['cantidad'];
                $precio      = $_POST['precio'];
                $producto_id = $_POST['producto_id'];
                $usuario_id  = $_SESSION['idUser'];
                
                $query_insert = mysqli_query($conection,"INSERT INTO entradas(codproducto,cantidad,precio,usuario_id)
                                                        VALUES($producto_id,$cantidad,$precio,$usuario_id)");
                
                if ($query_insert) {
                    //SI $query_insert) = true , se llama y se ejecuta el SP
                    $query_upd  = mysqli_query($conection,"CALL actualizar_precio_producto($cantidad, $precio,$producto_id)");
                    $result_pro = mysqli_num_rows($query_upd);
                    
                    if ($result_pro > 0) {
                    
                        $data = mysqli_fetch_assoc($query_upd);
                        $data['producto_id'] = $producto_id;
                        echo json_encode($data,JSON_UNESCAPED_UNICODE);
                        exit;
                    }
                }else {
                    echo'error.';
                }
                mysqli_close($conection);                                  

            }
        }else {
            echo'error.';
        }
        exit;
    }
    exit;
?>
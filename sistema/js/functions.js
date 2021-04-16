
$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
                $("#img").remove();
              }              
    });

    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

    });

    //Modal Form Add Product
    $('.add_product').click(function(e){
       e.preventDefault();
       var producto = $(this).attr('product');
       var action = 'infoProducto';
       //alert(producto);
       $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: true,
            data:{action:action,producto:producto},

            success: function(response) {
               
                //Validamos que response != a 'error' y convertimos los datos de formato JSON en un objeto javascript
                if (response != 'error') {
                    
                    //parsea response para convertir los datos de formato JSON a un Objeto JS.
                    var info = JSON.parse(response);
                    //console.log(info);

                    //Asignamos al campo de tipo hidden producto_id, el código de producto codproduct 
                    //$('#producto_id').val(info.codproducto);
                    //Asignamos el nombre del producto al formulario de manera automática.
                    //$('.nameProducto').html(info.descripcion);

                    $('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product"onsubmit="event.preventDefault(); sendDataProduct();">'+//
       
                                           '<h1><i class="fas fa-cubes"></i><br> Agregar Producto</h1>'+
                                            '<h2  class="nameProducto">'+info.descripcion+'</h2><br>'+
                                            '<input type="number" name="cantidad" id="txtCantidad" placeholder="Cantidad del producto" required><br>'+
                                            '<input type="number" name="precio" id="txtPrecio" placeholder="Precio del producto" required>'+
                                            '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required >'+
                                            '<input type="hidden" name="action" value="addProduct" required>'+
                                            '<div class="alert alertAddProduct"></div>'+
                                            '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+
                                            '<a href="#" class="btn_ok closeModal" onclick="closeModal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                          '</form>		')
                }

            },

            error: function(error) {
                console.log(error);
                
            }
       });
       
       $('.modal').fadeIn();
    });

});

function sendDataProduct(){
    //Limpiamos el div de alerta en caso tal arroje un error para que no se muestre cuando ingresamos un nuevo producto.
    $('.alertAddProduct').html('');
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: true,
        data:$('#form_add_product').serialize(),

        success: function(response) {
            if (response == 'error') {
                $('.alertAddProduct').html('<p style="color:red;">Error al agregar el producto</p>');
            }else{
                var info = JSON.parse(response);
                $('.row'+info.producto_id+' .celPrecio').html(info.nuevo_precio);
                $('.row'+info.producto_id+' .celExistencia').html(info.nueva_existencia);
                $('#txtCantidad').val('');
                $('#txtPrecio').val('');
                $('.alertAddProduct').html('<p>El producto se guardó correctamente</p>');
            }
        },

        error: function(error) {
            console.log(error);
            
        }
   });

}

function closeModal(){
    //Limpiamos los campos para cuando agreguemos un nuevo producto, no aparezcan los datos del anterior producto.
    $('.alertAddProduct').html('');
    $('#txtCantidad').val('');
    $('#txtPrecio').val('');
    
    $('.modal').fadeOut();
}
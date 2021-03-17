<?php 

    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db = 'facturation';

    $conection = @mysqli_connect($host,$user,$password,$db);


    if(!$conection){
        echo "Error al intentar Conectar.";
    }

?>
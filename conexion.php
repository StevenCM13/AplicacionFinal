<?php
function conectar()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "bar";

    $con = mysqli_connect($host, $user, $pass);
    mysqli_select_db($con, $bd);
    return $con;
}
/*
if ($con) {
    echo 'Conectado exitosamente a la base de datos';
} else {
    echo 'No se a podido conectar a la base de datos';
}
*/
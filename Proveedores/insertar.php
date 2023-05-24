<?php
include("../conexion.php");

$con = conectar();

$nit = $_POST["nit"];
$nombre_proveedor = $_POST["nombre_proveedor"];
$ciudad = $_POST["ciudad"];
$id_sede = $_POST["sede"];

$sql = "INSERT INTO `proveedores`( `nit`, `nombre_proveedor`, `ciudad`, `id_sede`, `fecha`) 
        VALUES ('$nit','$nombre_proveedor','$ciudad','$id_sede',NOW())";

if (mysqli_query($con, $sql)) {
    header("Location: proveedores.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);

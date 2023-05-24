<?php

include("../conexion.php");
$con = conectar();

$id_proveedor = $_GET['id_proveedor'];

$sql = "DELETE FROM proveedores WHERE `proveedores`.`id_proveedor` = '$id_proveedor'";
$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: proveedores.php");
}

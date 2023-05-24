<?php

include("../conexion.php");
$con = conectar();

$id_articulo = $_GET['id_articulo'];

$sql = "DELETE FROM inventario WHERE `inventario`.`id_articulo` = '$id_articulo'";
$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: articulos.php");
}

<?php

include("../conexion.php");
$con = conectar();

$id_mesa = $_GET['id_mesa'];

$sql = "DELETE FROM mesas WHERE `mesas`.`id_mesa` = '$id_mesa'";
$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: mesas.php");
}

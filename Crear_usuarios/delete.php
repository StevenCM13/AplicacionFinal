<?php

include("../conexion.php");
$con = conectar();

$id_usuario = $_GET['id_usuario'];

$sql = "DELETE FROM usuarios WHERE `usuarios`.`id_usuario` = '$id_usuario'";
$query = mysqli_query($con, $sql);

if ($query) {
    Header("Location: usuarios.php");
}

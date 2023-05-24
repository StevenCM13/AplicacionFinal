<?php
include("../conexion.php");

$con = conectar();

$numero_identificacion = $_POST["numero_identificacion"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$correo = $_POST["correo"];
$contraseña = $_POST["contraseña"];
$rol = $_POST["rol"];
$id_sede = $_POST["sede"];

$sql = "INSERT INTO usuarios (numero_identificacion, nombres, apellidos, correo, contraseña, rol, id_sede, fecha) VALUES ('$numero_identificacion', '$nombres', '$apellidos', '$correo', '$contraseña', '$rol', '$id_sede', NOW())";

if (mysqli_query($con, $sql)) {
    header("Location: usuarios.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);

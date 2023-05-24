<?php

include("../conexion.php");
$con = conectar();

//Para almacenar el id del usuario que tiene iniciada la sesión
session_start();
$correo = $_SESSION['admin'];
$id_usuario_query = mysqli_query($con, "SELECT id_usuario FROM usuarios WHERE correo = '$correo' AND rol = 'admin'");
$id_usuario = mysqli_fetch_assoc($id_usuario_query)['id_usuario'];

//Demas variables
$numero_mesa = $_POST["numero_mesa"];
$id_sede = $_POST["sede"];

// Verificar si ya existe un registro con los mismos valores
$sql = "SELECT * FROM mesas WHERE numero_mesa = '$numero_mesa' AND id_sede = '$id_sede'";
$query = mysqli_query($con, $sql);

if (mysqli_num_rows($query) > 0) {
    // Si el registro ya existe, mostrar un mensaje de error y redirigir a la página de mesas
    $_SESSION["mensaje_error"] = "El número de mesa ya existe en esta sede.";
    header("Location: mesas.php");
    exit();
} else {
    // Si el registro no existe, insertar un nuevo registro
    $sql = "INSERT INTO mesas (numero_mesa, id_sede, id_usuario, fecha) 
        VALUES ('$numero_mesa','$id_sede','$id_usuario',NOW())";
}

if (mysqli_query($con, $sql)) {
    header("Location: mesas.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

mysqli_close($con);

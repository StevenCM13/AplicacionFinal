<?php
//Inicializa la sesion
session_start();
//Si no existe la sesion se ejecuta:
if (!isset($_SESSION['admin'])) {
    echo '
        <script>
            alert ("Por favor inicia sesión");
            window.location="../index.php";
        </script>
    ';
    session_destroy();
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Administrador</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilo_admin.css">
</head>
<nav>
    <ul class="menu">
        <li><a href="../Crear_usuarios/usuarios.php">Crear usuarios</a></li>
        <li><a href="../Crear_mesas/mesas.php">Crear Mesas</a></li>
        <li><a href="mesero.php">Mesero</a></li>
        <li><a href="../cajero/cajero.php">Cajero</a></li>
        <li><a href="../Proveedores/proveedores.php">Crear proveedores</a></li>
        <li><a href="../Articulos/articulos.php">Productos bar</a></li>

        <li><a href="../cerrar_sesion.php">Cerrar sesión</a></li>

    </ul>
</nav>
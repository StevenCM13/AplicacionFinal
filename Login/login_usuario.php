<?php

//Inicializar las sesiones en PHP
session_start();

include '../conexion.php';
$con = conectar();

//Declaración de variables
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

//Validar admin
$validar_admin = mysqli_query($con, "SELECT * FROM usuarios WHERE correo = '$correo' 
AND contraseña = '$contraseña' AND rol = 'admin'");
// Validar mesero
$validar_mesero = mysqli_query($con, "SELECT * FROM usuarios WHERE correo = '$correo'
AND contraseña = '$contraseña' AND rol = 'mesero'");
//Validar cajero
$validar_cajero = mysqli_query($con, "SELECT * FROM usuarios WHERE correo = '$correo' 
AND contraseña = '$contraseña' AND rol = 'cajero' ");

// Obtener la sede del usuario
$sede_query = mysqli_query($con, "SELECT id_sede FROM usuarios WHERE correo = '$correo'");
$sede_result = mysqli_fetch_assoc($sede_query);
$sede_id = $sede_result['id_sede'];

if (empty($correo)) {
    echo '
    <script>
        alert ("Por favor ingresa el correo ");
        window.location = "../index.php";
    </script>
';
    exit();
} elseif (empty($contraseña)) {
    echo '
    <script>
        alert ("Por favor ingresa la contraseña ");
        window.location = "../index.php";
    </script>
';
    exit();
} elseif (mysqli_num_rows($validar_admin) > 0) {
    $_SESSION['admin'] = $correo;
    header("location: ../Administrador/menu_admin.php");
    exit();
} elseif (mysqli_num_rows($validar_mesero) > 0) {
    $_SESSION['mesero'] = $correo;
    $_SESSION['sede'] = $sede_id;
    header("location: ../mesero/mesero.php");
    exit();
} elseif (mysqli_num_rows($validar_cajero) > 0) {
    $_SESSION['cajero'] = $correo;
    $_SESSION['sede'] = $sede_id;
    header("location: ../cajero/cajero.php");
    exit();
} else {
    echo '
        <script>
            alert ("El usuario o la clave son incorrectas");
            window.location = "../index.php";
        </script>
    ';
    exit();
}
